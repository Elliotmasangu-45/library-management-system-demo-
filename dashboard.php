<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | User Dashboard</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <style>
        /* Define color variables */
        :root {
            --primary-color: #F38121;   /* Orange */
            --secondary-color: #4CAF50; /* Green */
            --text-color: #222222;      /* Dark Text */
            --accent-color: #800020;    /* Maroon */
            --light-bg-color: #F2F2F2;  /* Light background */
            --grey-color: #666666;      /* Grey */
        }

        body {
            background-color: var(--light-bg-color);
            color: var(--text-color);
            font-family: 'Open Sans', sans-serif;
        }

        /* Navbar Styling */
        .navbar {
            background-color: var(--primary-color); /* Primary color for the navbar */
            border-bottom: 2px solid var(--accent-color); /* Accent under the navbar */
        }

        .navbar a {
            color: var(--light-bg-color); /* Navbar link text */
        }

        .navbar a:hover {
            color: var(--accent-color); /* Navbar hover color */
        }

        /* Header line (Dashboard) */
        .header-line {
            color: var(--primary-color); /* Make the header-line stand out */
            border-bottom: 2px solid var(--secondary-color); /* Accent the header */
            padding-bottom: 10px;
            font-weight: bold;
        }

        /* Dashboard Widgets */
        .back-widget-set {
            background-color: var(--secondary-color); /* Background color for widgets */
            color: var(--light-bg-color); /* Widget text color */
            padding: 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .back-widget-set:hover {
            background-color: var(--primary-color); /* Hover state for the widgets */
        }

        /* Widget icons */
        .back-widget-set i {
            color: var(--accent-color); /* Icons in widgets */
        }

        .back-widget-set h3 {
            font-size: 22px;
            margin-top: 10px;
            font-weight: bold;
        }

        /* Footer Styling */
        footer {
            background-color: var(--grey-color); /* Footer background */
            color: var(--light-bg-color); /* Footer text color */
            padding: 10px 0;
            text-align: center;
        }

        footer a {
            color: var(--light-bg-color); /* Footer links */
        }

        footer a:hover {
            color: var(--primary-color); /* Footer link hover color */
        }
    </style>
</head>
<body>
    <!-- Menu Section -->
    <?php include('includes/header.php'); ?>
    <!-- Content Section -->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">User DASHBOARD</h4>
                </div>
            </div>

            <div class="row">
                <!-- Books Listed Widget -->
                <a href="listed-books.php">
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="back-widget-set text-center">
                            <i class="fa fa-book fa-5x"></i>
                            <?php 
                            $sql = "SELECT id FROM tblbooks";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $listdbooks = $query->rowCount();
                            ?>
                            <h3><?php echo htmlentities($listdbooks); ?></h3>
                            Books Listed
                        </div>
                    </div>
                </a>

                <!-- Books Not Returned Yet Widget -->
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="back-widget-set text-center">
                        <i class="fa fa-recycle fa-5x"></i>
                        <?php 
                        $rsts = 0;
                        $sid = $_SESSION['stdid'];
                        $sql2 = "SELECT id FROM tblissuedbookdetails WHERE StudentID = :sid AND (RetrunStatus = :rsts OR RetrunStatus IS NULL OR RetrunStatus = '')";
                        $query2 = $dbh->prepare($sql2);
                        $query2->bindParam(':sid', $sid, PDO::PARAM_STR);
                        $query2->bindParam(':rsts', $rsts, PDO::PARAM_STR);
                        $query2->execute();
                        $returnedbooks = $query2->rowCount();
                        ?>
                        <h3><?php echo htmlentities($returnedbooks); ?></h3>
                        Books Not Returned Yet
                    </div>
                </div>

                <!-- Issued Books Widget -->
                <a href="issued-books.php">
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="back-widget-set text-center">
                            <i class="fa fa-book fa-5x"></i>
                            <h3>&nbsp;</h3>
                            Issued Books
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- Footer Section -->
    <?php include('includes/footer.php'); ?>
    <!-- JavaScript Files -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
