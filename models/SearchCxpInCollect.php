<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        $sql = "SELECT * FROM CUENTPAGAR cxp WHERE cxp.CUEPACODIG LIKE '%" . $buscar . "%'"
                . "OR UPPER(cxp.CUEPAPROVE) LIKE UPPER ('%" . $buscar . "%')";
        buscar($sql, $buscar);
    }
    else
    {
        $sql = "SELECT * FROM CUENTPAGAR cxp ORDER BY cxp.CUEPACODIG DESC";
        buscar($sql, $buscar);
    }

    function buscar($sql, $buscar) {
        
        require './Conexion.php';
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        ?>
        <script src="../../js/prompt_collect_cxp.js"></script>
        <table>
            <tr>               
                <th>CODIGO</th>
                <th>PROVEEDOR</th>
                <th>IDENTIFICACION</th>
                <th>FECHA CREACION</th>
                <th>VALOR</th>
                <th>SALDO</th>
                <th>ACCION</th>
            </tr>  
        
            <?php
            $cont = 0;
            require_once './ClientImpl.php';
            
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {  
                $objClientImpl = new ClientImpl();
                $cliente = $objClientImpl->getNameClient($row[1]);
                
                if($cont%2 != 0){?>
                    <tr id="tdColor">
                <?php
                }else{?>
                    <tr>
                <?php }?>
                    <?php echo '<td id="td1'.$cont.'">'.$row[0]; ?></td>                                
                    <?php echo '<td id="td2'.$cont.'">'.$cliente; ?></td>  
                    <?php echo '<td id="td3'.$cont.'">'.$row[1]; ?></td>                                
                    <?php echo '<td id="td4'.$cont.'">'.$row[2]; ?></td>
                    <?php echo '<td id="td5'.$cont.'">'.number_format($row[6]); ?></td>                                
                    <?php echo '<td id="td6'.$cont.'">'.number_format($row[7]); ?></td>
                        
                    
                    
                    <td id="tdAcciones">
                        <?php
                            echo '<img class="imgEditClass" id="'.$cont.'" src="../../res/add-list-16.png">';                                                                
                        ?>                                        
                    </td>  
                </tr> 
        
            <?php
            $cont++;
            }?>
        </table>











    <?php }
?>