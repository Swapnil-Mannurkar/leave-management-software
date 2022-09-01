<?php
#database integration
require('db.inc.php');

#declaration of variable to display error message if any
$msg = " ";


if (isset($_POST['userid']) && isset($_POST['password'])) {
    $userid = mysqli_real_escape_string($con, $_POST['userid']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $res = mysqli_query($con, "select * from faculty where FID = '$userid' and password = '$password'");
    $count = mysqli_num_rows($res);
    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['ROLE'] = $row['Role'];
        $_SESSION['USER_NAME'] = $row['FName'];
        $_SESSION['USER_ID'] = $row['FID'];
        $_SESSION['DID'] = $row['DID'];
        $_SESSION['EMAIL_ID'] = $row['Email'];

        if ($_SESSION['ROLE'] == 'Admin') {
            header('location:Admin/faculty.php');
        } else if ($_SESSION['ROLE'] == 'Faculty') {
            header('location:Faculty/add_faculty.php?id=' . $_SESSION['USER_ID'] . "'");
        } else if ($_SESSION['ROLE'] == 'HOD') {
            header('location:HOD/add_faculty.php?id=' . $_SESSION['USER_ID'] . "'");
        } else if ($_SESSION['ROLE'] == 'Principal') {
            header('location:Principal/add_faculty.php?id=' . $_SESSION['USER_ID'] . "'");
        }
        die();
    } else {
        $msg = "Please enter correct login details!";
    }
}
?>

<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Title of the page displayed at the tab of the browser -->
    <title>Login Page</title>

    <!-- Integration of CSS files -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>

<body class="bg-dark">
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-form mt-150">

                    <!-- Inserting college logo in login page -->
                    <img src="assets\img\KLE.webp" style="padding-top: 0px; padding-bottom: 40px;">

                    <!-- Creating form for login (Username, password and login button) -->
                    <form method="post">

                        <!--Inserting username -->
                        <div class="form-group">
                            <label>USER ID</label>
                            <input type="text" name="userid" class="form-control" placeholder="Please enter your User-ID" required>
                        </div>

                        <!-- Inserting password -->
                        <div class="form-group">
                            <label>PASSWORD</label>
                            <input type="password" name="password" class="form-control" placeholder="Please enter your password" required>
                        </div>

                        <!-- For displaying login failure message -->
                        <div class="result_msg" style="text-align: center;"> <?php
                                                                                echo $msg
                                                                                ?></div>
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="assets/js/popper.min.js" type="text/javascript"></script>
    <script src="assets/js/plugins.js" type="text/javascript"></script>
    <script src="assets/js/main.js" type="text/javascript"></script>
</body>

</html>