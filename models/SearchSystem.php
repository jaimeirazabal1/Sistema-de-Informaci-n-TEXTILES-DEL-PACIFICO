<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        $sql = "SELECT * FROM sistema systm WHERE systm.SISTECODIG LIKE '%" . $buscar . "%'"
                . "OR UPPER(systm.SISTENOMBR) LIKE UPPER ('%" . $buscar . "%')";
                       
        buscar($sql, $buscar, 1);
    }
    else
    {
        $sql = "SELECT * FROM sistema systm ORDER BY systm.SISTECODIG ASC";
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
                <th>NOMBRE</th>                
                <th>VALOR</th>
                <th>FECHA INICIO</th>
                <th>FECHA FIN</th>
                <th>ACCION</th>
            </tr>  
        
            <?php
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {  ?> 
                <tr>
                    <td><?php echo $row[0]; ?></td>                                
                    <td><?php echo $row[1]; ?></td>                  
                    <td class="tdDerecha"><?php echo $row[2]; ?></td>  
                    <td><?php echo $row[3]; ?></td>  
                    <td><?php echo $row[4]; ?></td>  
                    <td id="tdAcciones">
                        <?php
                        echo '<a href = "edit_system.php?id='.$row[0].'"><img src = "../../res/edit-16.png"></a>';
                        //echo '<a href = "../../controllers/ctrlDeleteSystem.php?id='.$row[0].'"><img src = "../../res/delete-16.png"></a>';                                        
                        ?>                                        
                    </td>  
                </tr>
            <?php
            }
            ?>
        </table>
    <?php  
    }
?>