<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        $sql = "SELECT * FROM cuentpagpa cxpp WHERE cxpp.CUEPAPAGCO LIKE '%" . $buscar . "%'"
                . "OR UPPER(cxpp.CUEPAPAGOB) LIKE UPPER ('%" . $buscar . "%')";
                       
        buscar($sql, $buscar, 1);
    }
    else
    {
        $sql = "SELECT * FROM cuentpagpa cxpp WHERE ROWNUM <= 10 ORDER BY cxpp.CUEPAPAGCO DESC";
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
                <th>RECIBO</th>
                <th>No. CxP</th>                                
                <th>CONCEPTO</th>                                
                <th>VALOR</th>                                
                <th>FECHA</th>
                <th>OBSERVACIONES</th> 
                <th>PAGO</th>  
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
                    
                    <?php
                    require_once './ConceptImpl.php';
                    $objConceptImpl = new ConceptImpl();
                    $concepto = $objConceptImpl->getNameConcept($row['2']);
                    ?>                    
                    <td><?php echo $concepto; ?></td>
                                        
                    <td class="tdDerecha"><?php echo number_format($row[3]); ?></td>
                    <td><?php echo $row[4]; ?></td>
                    <td><?php echo $row[5]; ?></td>
                    <td><?php 
                        if(strcmp($row[6], 'C') == 0)
                            echo 'CONSIGNACION'; 
                        else if(strcmp($row[6], 'E') == 0)
                            echo 'EFECTIVO';
                    ?></td>
                    
                    <td id="tdAcciones">
                        <?php
//                        echo '<a href = "edit_collect.php?idr='.$row[0].'"><img src = "../../res/edit-16.png"></a>';
//                        echo '<a href = "../../controllers/ctrlDeleteCollect.php?idr='.$row[0].'&idc='.$row[1].'"><img src = "../../res/delete-16.png"></a>';                                        
                        echo '<a target="_blank" href="../../controllers/ctrlPrintCollectCxp.php?id='.$row[0].'&idc='.$row[1].'"><img src="../../res/printer-2-16.png"></a>';     
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