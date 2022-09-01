<?php
include('top.inc.php');
$fid = " ";
$did = " ";
$lt = "ntsld";
$lfdate = " ";
$ltdate =  " ";
$ldesc = " ";
$fa = array();
$faname = array();
$fadid = array();

if (isset($_POST['submit'])) {
    $fid = $_SESSION['USER_ID'];
    $did = $_SESSION['DID'];
    $lt = mysqli_real_escape_string($con, $_POST['lt']);
    $lfdate = mysqli_real_escape_string($con, $_POST['lfdate']);
    $ltdate = mysqli_real_escape_string($con, $_POST['ltdate']);
    $count = ($ltdate[-2] . $ltdate[-1]) - ($lfdate[-2] . $lfdate[-1]) + 1;

    $bdchkq = mysqli_query($con, "SELECT BDate FROM block_date");
    while ($bdchk = mysqli_fetch_assoc($bdchkq)) {
        if ($lfdate == $bdchk['BDate']) {
            header("location:add_leave.php?id=dateBlocked&type=block");
            die();
        }
    }

    $noclass = $_GET['var'];
    for ($x = 1; $x <= $noclass; $x++) {
        $fa[$x] = mysqli_real_escape_string($con, $_POST['fa' . $x . '']);
        $fadid[$x] = mysqli_real_escape_string($con, $_POST['fadid' . $x . '']);
        if ($fa[$x] != "none" && $fa[$x] != "ntsld") {
            $res = mysqli_query($con, "select FName from faculty where FID = '" . $fa[$x] . "'");
            $row = mysqli_fetch_assoc($res);
            $faname[$x] = $row['FName'];
        }
    }
    $ldesc = mysqli_real_escape_string($con, $_POST['ldesc']);

    if ($fa == "ntsld" || $fadid == "ntsld") {
        header('location:add_leave.php?id=Error&type=ntsld');
        die();
    }

    $afdate = $lfdate[8] . $lfdate[9];
    $atdate = $ltdate[8] . $ltdate[9];
    $vdate = date('d');
    $mindate = $vdate - 02;
    $minresult = preg_replace('/\b(\d)\b/', "0$1", $mindate);
    $maxdate = $vdate + 02;
    $maxresult = preg_replace('/\b(\d)\b/', "0$1", $maxdate);
    if ($afdate > $atdate) {
        header('location:add_leave.php?id=Error&type=adw');
        die();
    } else if (($fa == "none" || $fadid == "none") && $lt != "none") {
        mysqli_query($con, "insert into leave_applied values (' ','$fid','$did','$lt','$lfdate','$ltdate','$count','None','None','$ldesc',1,1,1);");
        header('location:leave.php');
        die();
    } else if ($afdate < $maxresult && $afdate > $minresult && $fa != "ntsld" && $lt != "ntsld" && $fadid != "ntsld") {
        $noclass = $_GET['var'];
        mysqli_query($con, "insert into leave_applied values (' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ' )");
        $max = mysqli_query($con, "select MAX(LID) as LID from Leave_applied");
        $maxv = mysqli_fetch_assoc($max);
        $lid = $_SESSION['LID'];
        $_SESSION['LID'] = $maxv['LID'];
        for ($x = 1; $x <= $noclass; $x++) {
            $faf = $fa[$x];
            $fanamef = $faname[$x];
            mysqli_query($con, "insert into leave_applied values ('$lid','$x','$fid','$did','$lt','$lfdate','$ltdate','$count','$faf','$fanamef','$ldesc',1,1,1);");
            #header('location:PHPMailer.php');
        }
        mysqli_query($con, "delete from leave_applied where SubLID = '0'");
        die();
    } else {
        header('location:add_leave.php?id=Error&type=adw');
        die();
    }
}

if (isset($_GET['var']) && $_GET['var'] == 'NaN') {
?>
    <script>
        alert("Please enter number of classes to be adjusted.");
        window.location.href = "add_leave.php"
    </script>
<?php
}

if (isset($_GET['id']) && $_GET['type'] == 'ntsld') {
?>
    <script>
        alert("Please enter all the details.");
    </script>
<?php
}

if (isset($_GET['id']) && $_GET['type'] == 'block') {
?>
    <script>
        alert("Sorry you cannot apply leave on this date (Date blocked by admin).");
    </script>
<?php
}

if (isset($_GET['id']) && $_GET['type'] == 'adw') {
?>
    <script>
        alert("Please enter correct details (Applied date is wrong).");
    </script>
<?php
}

?>

<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php if (isset($_GET['var'])) {
                    } else { ?>
                        <script>
                            var x = parseInt(prompt("Please enter number of classes to be adjusted"))
                            window.location.href = "add_leave.php?var=" + x;
                        </script>
                    <?php
                    }
                    $x = mysqli_real_escape_string($con, $_GET['var']);
                    $noclass = (int) $x; ?>
                    <div class="card-header"><strong>Add new leave</strong></div>
                    <div class="card-body card-block">
                        <form method="post">
                            <div class="form-group">

                                <label class="form-control-label" style="margin-top: 10px;">Leave type</label>
                                <select class="form-control" name="lt" required>
                                    <option value="ntsld" style="color: red;">Select type of leave</option>
                                    <?php
                                    $res = mysqli_query($con, "select * from leave_type;");
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo "<option value =" . $row['Leave_type'] . ">" . $row['Leave_type'] . "</option>";
                                    }
                                    ?>
                                </select>

                                <label class="form-control-label" style="margin-top: 10px;">Leave from</label>
                                <input type="date" name="lfdate" class="form-control" required>

                                <label class="form-control-label" style="margin-top: 10px;">Leave to</label>
                                <input type="date" name="ltdate" class="form-control" required>

                                <?php for ($x = 1; $x <= $noclass; $x++) { ?>

                                    <label class="form-control-label" style="margin-top: 10px;">Adjustment faculty <?php echo $x ?> department name</label>
                                    <select class="form-control" name="fadid<?php echo $x ?>" required>
                                        <option value="ntsld" style="color: red;">Select Department</option>
                                        <option value="none">No adjustment required</option>
                                        <?php
                                        $res = mysqli_query($con, "select * from department order by DID;");
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            echo "<option value =" . $row['DID'] . ">" . $row['DName'] . " (" . $row['DID'] . ")" . "</option>";
                                        }
                                        ?>
                                    </select>

                                    <label class="form-control-label" style="margin-top: 10px;">Adjust faculty <?php echo $x ?></label>
                                    <select class="form-control" name="fa<?php echo $x ?>" required>
                                        <option value="ntsld" style="color: red;">Select faculty</option>
                                        <option value="none">No adjustment required</option>
                                        <?php
                                        $res = mysqli_query($con, "select * from faculty where Role <> 'Admin' and FID <>'" . $_SESSION['USER_ID'] . "' and DID ='" . $_SESSION['DID'] . "';");
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            echo "<option value =" . $row['FID'] . ">" . $row['FID'] . " " . $row['FName'] . " (" . $row['DID'] . ")" . "</option>";
                                        }
                                        ?>
                                    </select>

                                <?php } ?>

                                <label class="form-control-label" style="margin-top: 10px;">Leave description</label>
                                <input type="text" name="ldesc" class="form-control">
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