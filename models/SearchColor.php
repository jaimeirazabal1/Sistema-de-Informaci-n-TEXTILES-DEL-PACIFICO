<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        $sql = "SELECT * FROM color clr WHERE clr.COLORCODIG LIKE '%" . $buscar . "%'"
                . "OR UPPER(clr.COLORNOMBR) LIKE UPPER ('%" . $buscar . "%')";
                       
        buscar($sql, $buscar, 1);
    }
    else
    {
        $sql = "SELECT * FROM color clr ORDER BY clr.COLORCODIG ASC";
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
                <th>ACCION</th>
            </tr>  
        
            <?php
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {  ?> 
                <tr>
                    <td><?php echo $row[0]; ?></td>                                
                    <td><?php echo $row[1]; ?></td>                  
                    <td id="tdAcciones">
                        <?php
                        echo '<a href = "edit_color.php?id='.$row[0].'"><img src = "../../res/edit-16.png"></a>';
                        echo '<a href = "../../controllers/ctrlDeleteColor.php?id='.$row[0].'"><img src = "../../res/delete-16.png"></a>';                                        
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