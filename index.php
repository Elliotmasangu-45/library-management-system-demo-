<?php
session_start();
error_reporting(0);
include('includes/config.php');

if ($_SESSION['login'] != '') {
    $_SESSION['login'] = '';
}
if (isset($_POST['login'])) {
    $email = $_POST['emailid'];
    $password = md5($_POST['password']);
    $sql = "SELECT EmailId, Password, StudentId, Status FROM tblstudents WHERE EmailId=:email and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['stdid'] = $result->StudentId;
            if ($result->Status == 1) {
                $_SESSION['login'] = $_POST['emailid'];
                echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
            } else {
                echo "<script>alert('Your Account Has been blocked. Please contact admin');</script>";
            }
        }
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
    <title>Mahikeng local Library Management System | User Login</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <style>
        :root {
            --e-global-color-primary: #F38121;
            --e-global-color-secondary: #4CAF50;
            --e-global-color-text: #222222;
            --e-global-color-accent: #800020;
            --e-global-color-fb007b3: #F2F2F2;
            --e-global-color-5a54ecc: #666666;
        }

        body {
            background-color: #fb007b3; /* Set the background color */
            font-family: 'Open Sans', sans-serif;
            color: var(--e-global-color-text);
           
        }

        .header-line {
            color: --e-global-color-text; /* Adjusted header color for visibility */
        }

        .panel-info {
            border-color: var(--e-global-color-primary);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .panel-info > .panel-heading {
            color: white;
            background-color: var(--e-global-color-primary);
            border-color: var(--e-global-color-primary);
            border-radius: 10px 10px 0 0;
            padding: 15px;
        }

        .panel-body {
            background-color: var(--e-global-color-fb007b3);
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }

        .form-control {
            border: 1px solid var(--e-global-color-secondary);
            border-radius: 5px;
            padding: 10px;
            transition: border 0.3s;
        }

        .form-control:focus {
            border-color: var(--e-global-color-primary);
            box-shadow: 0 0 5px var(--e-global-color-primary);
        }

        .btn-info {
            background-color: var(--e-global-color-secondary);
            border-color: var(--e-global-color-secondary);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-info:hover {
            background-color: var(--e-global-color-accent);
            border-color: var(--e-global-color-accent);
        }

        .help-block a {
            color: var(--e-global-color-primary);
        }

        .help-block a:hover {
            text-decoration: underline;
        }

        .carousel-inner img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            background-color: var(--e-global-color-primary);
            color: white;
            margin-top: 20px;
            border-radius: 10px;
        }

        h4 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: white; /* Adjusted for better visibility */
        }
    </style>
</head>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <!--Slider---->
            <div class="row">
                <div class="col-md-10 col-sm-8 col-xs-12 col-md-offset-1">
                    <div id="carousel-example" class="carousel slide slide-bdr" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="assets/img/oo.jpeg" alt="" />
                            </div>
                            <div class="item">
                                <img src="assets/img/111.jpeg" alt="" />
                            </div>
                            <div class="item">
                                <img src="assets/img/22.jpeg" alt="" />
                            </div>
                            <div class="item">
                                <img src="assets/img/777.jpeg" alt=""/>
                        </div>
                            <div class="item">
                                <img src="assets/img/infs.jpeg" alt=""/>
                        </div>

                        <!--INDICATORS-->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example" data-slide-to="1"></li>
                            <li data-target="#carousel-example" data-slide-to="2"></li>
                            <li data-target="#carousel-example" data-slide-to="3"></li>
                            <li data-target="#carousel-example" data-slide-to="4"></li>

                        </ol>
                        <!--PREVIOUS-NEXT BUTTONS-->
                        <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>
            </div>
            <hr />

            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">USER LOGIN FORM</h4>
                </div>
            </div>
            <a name="ulogin"></a>
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
                                    <label>Enter Email id</label>
                                    <input class="form-control" type="text" name="emailid" required autocomplete="off" />
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="password" required autocomplete="off" />
                                    <p class="help-block"><a href="user-forgot-password.php">Forgot Password</a></p>
                                </div>

                                <button type="submit" name="login" class="btn btn-info">LOGIN</button> |
                                <a href="signup.php">Not Registered Yet?</a>
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
    <div class="footer">
        <p>&copy; <?php echo date("Y"); ?> MHK Library Management System.</p>
    </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>

</body>

</html>
