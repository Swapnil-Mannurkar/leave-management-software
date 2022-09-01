<?php
include('top.inc.php');
if (isset($_POST['submit'])) {
    $fid = mysqli_real_escape_string($con, $_POST['fid']);
    $frole = mysqli_real_escape_string($con, $_POST['frole']);
    mysqli_query($con, "UPDATE faculty SET Role ='".$_POST['frole']."' where FID = '" . $fid . "';");
    echo $fid;
    echo $frole;
}
?>
<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Change role of faculty</strong></div>
                    <div class="card-body card-block">
                        <form method="post">
                            <div class="form-group">
                                <label class="form-control-label">Select faculty </label>
                                <select class="form-control" name="fid" required>
                                    <option value=" " style="color: red;">Select faculty whose role to be changed</option>
                                    <?php
                                    $res = mysqli_query($con, "SELECT * FROM faculty WHERE DID = '" . $_SESSION['DID'] . "' AND Role <> 'Admin' AND Role <> 'Principal' AND FName <>'" . $_SESSION['USER_NAME'] . "';");
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo "<option value =" . $row['FID'] . ">" . $row['FID'] . " " . $row['FName'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Select role </label>
                                <select name="frole" class="form-control">
                                    <option value=" " style="color: red;"> Select the role to be given</option>
                                    <option value="Faculty">Faculty</option>
                                    <option value="HOD">HOD</option>
                                </select>
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