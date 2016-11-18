<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        $sql = "SELECT * FROM factura fctr WHERE fctr.FACTUCODIG LIKE '%" . $buscar . "%'"
                . "OR UPPER(fctr.FACTUCLIEN) LIKE UPPER ('%" . $buscar . "%')";
        buscar($sql, $buscar);
    }
    else
    {
        $sql = "SELECT * FROM factura fctr ORDER BY fctr.FACTUCODIG DESC";
        buscar($sql, $buscar);
    }

    function buscar($sql, $buscar) {
        require './Conexion.php';
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        ?>
        
        <table>
            <tr>
                <th>CODIGO</th>
                <th>CLIENTE</th>
                <th>IDENTIFICACION</th>
                <th>FECHA CREACION</th>
<!--                <th>VALOR</th>
                <th>COSTO</th>-->
                <th>VALOR</th>
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
                    <td><?php echo $row[0]; ?></td>                                
                    <td><?php echo $cliente; ?></td>
                    <td><?php echo $row[1]; ?></td>
                    <td><?php echo $row[2]; ?></td>
                    <td class="tdDerecha"><?php echo number_format($row[3]); ?></td>
<!--                    <td><?php //echo $row[3]; ?></td>
                    <td><?php //echo //$row[4]; ?></td>-->
                    
                    
                    
                    
                    <td id="tdAcciones">
                        <?php
                        echo '<a href="view_bill.php?id='.$row[0].'"><img src="../../res/undo-2-16.png"></a>';
                        ?>                                        
                    </td>  
                </tr> 
        
            <?php
            $cont++;
            }?>
        </table>











    <?php }
?>