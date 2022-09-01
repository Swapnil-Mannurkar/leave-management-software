<?php
include('top.inc.php');

if (isset($_POST['submit'])) {
    if (isset($_GET['id'])) {
        $bdid = mysqli_real_escape_string($con,$_GET['id']);
        $bdate = mysqli_real_escape_string($con, $_POST['bdate']);
        $bpur = mysqli_real_escape_string($con, $_POST['bpurpose']);
        mysqli_query($con, "UPDATE block_date SET BDate = '".$bdate."' WHERE BDID = '".$bdid."';");
        mysqli_query($con, "UPDATE block_date SET BDPurpose = '".$bpur."'WHERE BDID = '".$bdid."';");
        header('location:blockdate.php');
        die();
    } else {
        $bdate = mysqli_real_escape_string($con, $_POST['bdate']);
        $bpurpose = mysqli_real_escape_string($con, $_POST['bpurpose']);
        mysqli_query($con, "INSERT INTO block_date VALUES('','$bdate','$bpurpose');");
        header('location:blockdate.php');
        die();
    }
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    if ($_SESSION['ROLE'] != 'Admin') {
        header("location:add_faculty.php?id='" . $_SESSION['USER_ID'] . "'");
        die();
    } else {
        $res = mysqli_query($con, "SELECT * FROM block_date WHERE BDID = '" . $id . "';");
        $row = mysqli_fetch_assoc($res);
        $bdate = $row['BDate'];
        $bdpur = $row['BDPurpose'];
    }
}
?>

<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Add new leave</strong></div>
                    <div class="card-body card-block">
                        <form method="post">
                            <div class="form-group">
                                <?php if (isset($_GET['id'])) { ?>

                                    <label class="form-control-label" style="margin-top: 10px;">Date to be blocked</label>
                                    <input type="date" name="bdate" class="form-control" value="<?php echo $bdate ?>">

                                    <label class="form-control-label" style="margin-top: 10px;">Block date purpose</label>
                                    <input type="text" name="bpurpose" class="form-control" value="<?php echo $bdpur ?>">
                                <?php } else { ?>
                                    <label class="form-control-label" style="margin-top: 10px;">Date to be blocked</label>
                                    <input type="date" name="bdate" class="form-control" required>

                                    <label class="form-control-label" style="margin-top: 10px;">Block date purpose</label>
                                    <input type="text" name="bpurpose" class="form-control">
                                <?php } ?>
                            </div>

                            <div style="margin: 0px 500px">
                                <button type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                                    <span id="payment-button-amount">Submit</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('footer.inc.php');
?>