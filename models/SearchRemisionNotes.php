<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        $sql = "SELECT * FROM remision rms WHERE rms.REMISCODIG LIKE '%" . $buscar . "%'"
                . "OR UPPER(rms.REMISCLIEN) LIKE UPPER ('%" . $buscar . "%')";
        buscar($sql, $buscar);
    }
    else
    {
        $sql = "SELECT * FROM remision rms WHERE ROWNUM <= 5 ORDER BY rms.REMISCODIG DESC";
        buscar($sql, $buscar);
    }

    function buscar($sql, $buscar) {
        require './Conexion.php';
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        ?>
        <script src="../../js/prompt_note.js"></script>
        <table>
            <tr>
                <th>REMISION</th>
                <th>CLIENTE</th>
                <th class="tdNoVisible">TIPO ID</th>
                <th>TIPO</th>
                <th>NIT/CC</th>
                <th>FECHA</th>
<!--                <th>VALOR</th>
                <th>COSTO</th>-->
                <th>VALOR</th>
                <th>ACCION</th>
            </tr>  
        
            <?php
            $cont = 0;
            require_once './ClientImpl.php';
            require './TypeClientImpl.php';
            $objTypeClientImpl = new TypeClientImpl();
            
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {  
                $objClientImpl = new ClientImpl();
                $cliente = $objClientImpl->getNameClient($row[1]);
                
                if($cont%2 != 0){?>
                    <tr id="tdColor">
                <?php
                }else{?>
                    <tr>
                <?php }?>
                    <?php
                    echo '<td class="tdDerecha" id="td1'.$cont.'">'.$row[0].'</td>';                                
                    echo '<td id="td2'.$cont.'">'.$cliente.'</td>';
                    
                    $idTC = $objClientImpl->getTypeClient($row[1]);
                    echo '<td class="tdNoVisible" id="td6'.$cont.'">'.$idTC; 
                    echo '<td id="td7'.$cont.'">'.$objTypeClientImpl->getNameTypeClient($idTC); 
                    
                    echo '<td class="tdDerecha" id="td3'.$cont.'">'.$row[1].'</td>';
                    echo '<td id="td4'.$cont.'">'.$row[2].'</td>';
                    echo '<td class="tdDerecha" id="td5'.$cont.'">'.number_format($row[3]).'</td>';
                    ?>
                    
                    
                    
                    
                    <td id="tdAcciones">
                        <?php
                        echo '<a href="../notes/add_ntcr.php?idf='.$row[0].'"> <img id="'.$cont.'" src="../../res/add-list-16.png"></a>';                                                                                
                        //echo '<img class="imgEditClass" id="'.$cont.'" src="../../res/add-list-16.png">'; 
                        ?>                                        
                    </td>  
                </tr> 
        
            <?php
            $cont++;
            }?>
        </table>











    <?php }
?>