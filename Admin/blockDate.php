<?php
include('top.inc.php');

if(isset($_GET['type']) && $_GET['type']=='delete'){
    $id = mysqli_real_escape_string($con, $_GET['id']);
    echo $id;
    mysqli_query($con, "delete from block_date where BDID = '$id'");
    header('location:blockDate.php');
   die();
}
$res = mysqli_query($con, "select * from block_date");
?>

<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title" style="font-size:25px;">List of block dates</h4>
                        <h4 class="box-title" style="font-size:12px;"><a href="addbdate.php">Add new block date</a></h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Block date ID</th>
                                        <th>Block date</th>
                                        <th>Block date purpose</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($res)) { ?>
                                        <tr>
                                            <td><?php echo $i ?> </td>
                                            <td><?php echo $row['BDID'] ?></td>
                                            <td><?php echo $row['BDate'] ?></td>
                                            <td><?php echo $row['BDPurpose'] ?></td>
                                            <td>
                                                <a href="addbdate.php?id=<?php echo $row['BDID'] ?>" style="margin-left: 20px;">EDIT</a>
                                                <a href="blockDate.php?id=<?php echo $row['BDID'] ?>&type=delete" style="margin-left:20px;">DELETE</a>
                                            </td>
                                            <td></td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.inc.php')
?>