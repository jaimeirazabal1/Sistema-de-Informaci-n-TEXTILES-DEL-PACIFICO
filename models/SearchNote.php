<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        $sql = "SELECT * FROM nota nta WHERE nta.NOTACODIG LIKE '%" . $buscar . "%'"
                . "OR UPPER(nta.NOTAFACTU) LIKE UPPER ('%" . $buscar . "%')"
                . "OR UPPER(nta.NOTATIPNO) LIKE UPPER ('%" . $buscar . "%')";
                       
        buscar($sql, $buscar, 1);
    }
    else
    {
        $sql = "SELECT * FROM nota nta WHERE ROWNUM <= 10 ORDER BY nta.NOTACODIG DESC";
        buscar($sql, $buscar, 0);
    }

    function buscar($sql, $buscar, $flag) {
        require './Conexion.php';
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        ?>
        <table>
            <tr>
                <th>CODIGO</th>
                <th>FACTURA</th>                                
                <th>FECHA</th>                                
                <th>TIPO</th>                                
                <th>VALOR</th>
                <th>IVA</th>                                
                <th>ACCION</th>
            </tr>  
        
            <?php
            $cont = 0;
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {    
                if($cont%2 != 0){?>
                    <tr id="tdColor">
                <?php
                }else{?>
                    <tr>
                <?php }?>
                    <td class="tdDerecha"><?php echo $row[0]; ?></td>                                
                    <td class="tdDerecha"><?php echo $row[1]; ?></td>
                    <td><?php echo $row[2]; ?></td>
                    
                    <?php
                    if(strcmp ($row[3], 'DE') == 0 || strcmp ($row[3], 'de') == 0)
                        echo '<td>DEBITO</td>';
                    else if(strcmp ($row[3], 'CR') == 0 || strcmp ($row[3], 'cr') == 0)
                        echo '<td>CREDITO</td>';
                    else
                        echo '<td></td>';
                    ?> 
                    
                    <td class="tdDerecha"><?php echo number_format($row[4]); ?></td>                                                              
                    <td class="tdDerecha"><?php echo number_format($row[5]); ?></td>
                                        
                    <td id="tdAcciones">
                        <?php
                        if(strcmp($row[3], "CR") == 0){
                            echo '<a href="note_credito.php?idf='.$row[1].'&idn='.$row[0].'"><img src="../../res/edit-16.png"></a>';                                         
                            echo '<a target="_blank" href="../../controllers/ctrlPrintNoteCR.php?id='.$row[0].'"><img src="../../res/printer-2-16.png"></a>';     
                        }
                        else if(strcmp($row[3], "DE") == 0){
                            echo '<a href="note_debito.php?idf='.$row[1].'&idn='.$valor->getCode().'"><img src="../../res/edit-16.png"></a>';                         
                            echo '<a target="_blank" href="../../controllers/ctrlPrintNoteDB.php?id='.$row[0].'"><img src="../../res/printer-2-16.png"></a>';     
                        }
                        ?>                                                                  
                    </td>  
                </tr> 
        
            <?php            
            $cont++;
            }
            ?>
        </table>
    <?php 
        if($flag == 0)
        {
            require_once './ClientImpl.php';
            $objClientImpl = new ClientImpl();
            echo '<p>Ultimos registros de '.$objClientImpl->getCount().' encontrados</p>';
        }
    
    }
?>