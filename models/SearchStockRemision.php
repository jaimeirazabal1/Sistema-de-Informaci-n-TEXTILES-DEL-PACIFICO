<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        //$sql = "SELECT * FROM inventario invtr WHERE invtr.INVENMOVIM = 'E' AND UPPER(invtr.INVENCODIG) LIKE UPPER ('%" . $buscar . "%')"
          //      . "OR invtr.INVENMOVIM = 'E' AND UPPER(invtr.INVENNOMBR) LIKE UPPER ('%" . $buscar . "%')";
        
        $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR, invtr.INVENCOLOR FROM inventario invtr "
                ."WHERE invtr.INVENMOVIM = 'E' AND UPPER(invtr.INVENCODIG) LIKE UPPER ('%" . $buscar . "%') ORDER BY invtr.INVENCODIG";
                
        
        
        buscar($sql, $buscar);
    }
    else
    {
        $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR, invtr.INVENCOLOR FROM inventario invtr WHERE ROWNUM <= 5 AND invtr.INVENMOVIM = 'E' ORDER BY invtr.INVENCODIG";
        buscar($sql, $buscar);
    }

    function buscar($sql, $buscar) {
        require './Conexion.php';
        require './StockImpl.php';
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        ?>
        <script src="../../js/prompt.js"></script>
        <table>
            <tr>
                <th>REFERENCIA</th>
                <th>ARTICULO</th>
                <th>CANTIDAD</th>
                <th class="tdNoVisible">PRECIO COSTO</th>
                <th>COLOR</th>
                <th class="tdNoVisible">PRECIO VENTA</th>
                <th>ACCION</th>
            </tr>  
        
            <?php
            $objStockImpl = new StockImpl();
            require './ColorImpl.php';
            $objColorImpl = new ColorImpl();
            
            $cont = 0;
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                $quantityAvailable = $objStockImpl->getQuantityAvailable($row[0], $row[2]);
                $quantitySale = $objStockImpl->getQuantitySale($row[0], $row[2]);
                $totalCantidad = $quantityAvailable - $quantitySale; 
                $idColor = $row[2];
                $valueSaleUnit = $objStockImpl->getLastPriceVenta($row[0], $row[2]);
                
            if($totalCantidad>0){
                if($cont%2 != 0){?>
                    <tr id="tdColor">
                <?php
                }else{?>
                    <tr>
                <?php }?>
                    
                    <?php echo '<td id="td1'.$cont.'">'.$row[0]; ?></td>                                
                    <?php echo '<td id="td2'.$cont.'">'.$row[1]; ?></td>
                    
                    <?php
                    echo '<td class="tdDerecha" id="td3' . $cont . '">';
                    
                    echo $totalCantidad;

                    echo '</td>';
                    
                    echo '<td class="tdNoVisible" id="td4'.$cont.'">';
                    $priceBuy = $objStockImpl->getLastPriceSold($row[0], $row[2]); 
                    echo number_format($priceBuy,0);
                    echo '</td>';
                    
                    echo '<td id="td5'.$cont.'">'.$objColorImpl->getNameColor($idColor).'</td>';
                    
                    echo '<td class="tdNoVisible" id="td6'.$cont.'">'.$idColor.'</td>';
                    echo '<td class="tdNoVisible" id="td7'.$cont.'">'.$valueSaleUnit.'</td>';
                    
                    ?>
                    
                   
                                        
                    <td id="tdAcciones">
                        <?php
                        //echo '<a href="edit_detail.php?idf='.$_POST['id'].'&ida='.$row[0].'&n='.$row[1].'&pc='.$row[4].'&pv='.$row[5].'&m='.$$row[2].'&u='.$row[6].'&fm='.$row[7].'"><img src="../../res/add-list-16.png"></a>';                                        
                        echo '<img class="imgEditClass" id="'.$cont.'" src="../../res/add-list-16.png">';
                        ?>                                        
                    </td>  
                </tr> 
        
            <?php
            $cont++;
            }
            }
            ?>
        </table>











    <?php }
?>