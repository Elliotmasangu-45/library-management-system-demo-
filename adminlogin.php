<?php
session_start();
error_reporting(0);
include('includes/config.php');
if($_SESSION['alogin'] != '') {
    $_SESSION['alogin'] = '';
}
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT UserName, Password FROM admin WHERE UserName=:username and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0) {
        $_SESSION['alogin'] = $_POST['username'];
        echo "<script type='text/javascript'> document.location ='admin/dashboard.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Mahikeng local Library Management System</title>

    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <style>
        :root {
            --e-global-color-primary: #F38121; /* Original Primary Color */
            --e-global-color-secondary: #4CAF50; /* Original Secondary Color */
            --e-global-color-text: #222222; /* Original Text Color */
            --e-global-color-accent: #800020; /* Original Accent Color */
            --e-global-color-bg: #F2F2F2; /* Original Background Color */
            --e-global-color-border: #666666; /* Original Border Color */
            --e-global-color-lightblue: #ADD8E6; /* Light Blue Color */
        }
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #fb007b3; /* Soft warm background color for user-friendliness */
            color: var(--e-global-color-text);
        }
        .header-line {
            color: var(white);
            border-bottom: 2px solid var(--e-global-color-primary);
            padding-bottom: 10px;
        }
        .panel-info {
            border-color: var(--e-global-color-primary);
            box-shadow: 0 0 10px rgba(173, 216, 230, 0.5); /* Light blue shadow for the panel */
        }
        .panel-heading {
             background-color: var(--e-global-color-primary); 
            color: var(--e-global-color-primary); 
            font-weight: bold; (--e-global-color-lightblue);">
        }
        .btn-info {
            background-color: var(--e-global-color-secondary);
            border-color: var(--e-global-color-secondary);
            transition: background-color 0.3s ease;
        }
        .btn-info:hover {
            background-color: var(--e-global-color-accent);
            border-color: var(--e-global-color-accent);
            box-shadow: 0 0 10px rgba(173, 216, 230, 0.5); /* Light blue glow on button hover */
        }
        .form-control {
            border: 1px solid var(--e-global-color-border);
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: var(--e-global-color-orange); /* Light blue border on focus */
            box-shadow: 0 0 5px rgba(173, 216, 230, 0.5); /* Light blue glow on focus */
        }
    </style>
</head>
<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">ADMIN LOGIN FORM</h4>
                </div>
            </div>
             
            <!--LOGIN PANEL START-->           
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            LOGIN FORM
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>Enter Username</label>
                                    <input class="form-control" type="text" name="username" autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="password" autocomplete="off" required />
                                </div>

                                <button type="submit" name="login" class="btn btn-info">LOGIN</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>  
            <!---LOGIN PANEL END-->            
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->

    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
