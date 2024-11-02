<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
{   
header('location:index.php');
}
else{
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Issued Books</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DATATABLE STYLE  -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <style>
        /* Color variables */
        :root {
            --e-global-color-primary: #F38121;   /* Primary (orange) */
            --e-global-color-secondary: #4CAF50; /* Secondary (green) */
            --e-global-color-text: #222222;      /* Text (dark grey) */
            --e-global-color-accent: #800020;    /* Accent (maroon) */
            --e-global-color-fb007b3: #F2F2F2;   /* Light Background (light grey) */
            --e-global-color-5a54ecc: #666666;   /* Grey */
        }

        body {
            background-color: var(--e-global-color-fb007b3); /* Light grey background */
            color: var(--e-global-color-text); /* Dark grey text */
        }

        .header-line {
            color: var(--e-global-color-primary); /* Orange header text */
        }

        .panel-heading {
            background-color: var(--e-global-color-secondary); /* Green panel header */
            color: white;
        }

        .table th {
            background-color: var(--e-global-color-primary); /* Orange table header */
            color: white;
        }

        .table td {
            color: var(--e-global-color-text); /* Dark grey table text */
        }

        .alert-danger {
            background-color: var(--e-global-color-accent); /* Maroon background for danger alert */
            color: white;
        }

        .alert-success {
            background-color: var(--e-global-color-secondary); /* Green background for success alert */
            color: white;
        }

        .btn-primary {
            background-color: var(--e-global-color-primary); /* Orange buttons */
            border-color: var(--e-global-color-primary);
        }

        .btn-primary:hover {
            background-color: var(--e-global-color-accent); /* Maroon hover for buttons */
            border-color: var(--e-global-color-accent);
        }
    </style>
</head>
<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php');?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Manage Issued Books</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Issued Books
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Book Name</th>
                                            <th>ISBN</th>
                                            <th>Issued Date</th>
                                            <th>Return Date</th>
                                            <th>Fine in (USD)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
$sid=$_SESSION['stdid'];
$sql="SELECT tblbooks.BookName,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.id as rid,tblissuedbookdetails.fine from  tblissuedbookdetails join tblstudents on tblstudents.StudentId=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId where tblstudents.StudentId=:sid order by tblissuedbookdetails.id desc";
$query = $dbh -> prepare($sql);
$query-> bindParam(':sid', $sid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               
?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookName);?></td>
                                            <td class="center"><?php echo htmlentities($result->ISBNNumber);?></td>
                                            <td class="center"><?php echo htmlentities($result->IssuesDate);?></td>
                                            <td class="center"><?php if($result->ReturnDate=="")
                                            { ?>
                                            <span style="color:red">
                                             <?php echo htmlentities("Not Return Yet"); ?>
                                                </span>
                                            <?php } else {
                                            echo htmlentities($result->ReturnDate);
                                            } ?>
                                            </td>
                                            <td class="center"><?php echo htmlentities($result->fine);?></td>
                                        </tr>
<?php $cnt=$cnt+1;}} ?>                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- DATATABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
