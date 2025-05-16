<?php
include('../../config.php');

try {
    $stmt = $con->prepare("SELECT * FROM tbl_screens WHERE t_id = :id");
    $stmt->execute(['id' => $_POST['id']]);
    
    if($stmt->rowCount() > 0) {
    ?>
        <table class="table table-bordered table-hover">
            <th class="col-md-1">Slno</th>
            <th class="col-md-3">Screen Name</th>
            <th class="col-md-1">Seats</th>
            <th class="col-md-1">Charge</th>
            <th class="col-md-3">Show Time</th>
            <th class="text-right col-md-3">
                <button data-toggle="modal" data-target="#view-modal" id="getUser" class="btn btn-sm btn-info">
                    <i class="fa fa-plus"></i> Add Screen
                </button>
            </th>
            <?php 
            $sl=1;
            while($screen = $stmt->fetch()) {
            ?>
                <tr>
                    <td><?php echo $sl;?></td>
                    <td><?php echo $screen['screen_name'];?></td>
                    <td><?php echo $screen['seats'];?></td>
                    <td><?php echo $screen['charge'];?></td>
                    <?php 
                    $stmt2 = $con->prepare("SELECT * FROM tbl_show_time WHERE screen_id = :screen_id");
                    $stmt2->execute(['screen_id' => $screen['screen_id']]);
                    ?>
                    <td>
                        <?php 
                        if($stmt2->rowCount() > 0) {
                            while($stm = $stmt2->fetch()) {
                                echo date('h:i a',strtotime($stm['start_time']))." ,";
                            }
                        } else {
                            echo "No Show Time Added";
                        }
                        ?>
                    </td>
                    <td class="text-right">
                        <button data-toggle="modal" data-id="<?php echo $screen['screen_id'];?>" 
                                data-target="#view-modal2" id="getUser2" class="btn btn-sm btn-warning">
                            <i class="fa fa-plus"></i> Add Show Times
                        </button>
                    </td>
                </tr>
                <?php
                $sl++;
            }
            ?>
        </table>
    <?php
    } else {
    ?>
        <button data-toggle="modal" data-target="#view-modal" id="getUser" class="btn btn-sm btn-info">
            <i class="fa fa-plus"></i> Add Screen
        </button>
    <?php
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>