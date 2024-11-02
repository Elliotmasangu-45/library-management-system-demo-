<?php 
session_start();
include('includes/config.php');
error_reporting(0);

if(isset($_POST['signup']))
{
    // Code for student ID
    $count_my_page = ("studentid.txt");
    $hits = file($count_my_page);
    $hits[0]++;
    $fp = fopen($count_my_page , "w");
    fputs($fp , "$hits[0]");
    fclose($fp); 
    $StudentId = $hits[0];   
    $fname = $_POST['fullanme'];
    $mobileno = $_POST['mobileno'];
    $email = $_POST['email']; 
    $password = md5($_POST['password']); 
    $status = 1;

    $sql = "INSERT INTO tblstudents(StudentId,FullName,MobileNumber,EmailId,Password,Status) VALUES(:StudentId, :fname, :mobileno, :email, :password, :status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':StudentId', $StudentId, PDO::PARAM_STR);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();

    $lastInsertId = $dbh->lastInsertId();
    if($lastInsertId)
    {
        // Show an alert and redirect to index.php
        echo '<script>
                alert("Your Registration is successful and your student ID is ' . $StudentId . '");
                window.location.href = "index.php"; // Redirect to index.php after successful registration
              </script>';
    }
    else 
    {
        echo "<script>alert('Something went wrong. Please try again');</script>";
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
    <title>Online Library Management System | Student Signup</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
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
    </style>

    <script type="text/javascript">
    function valid()
    {
        if(document.signup.password.value != document.signup.confirmpassword.value)
        {
            alert("Password and Confirm Password Field do not match!");
            document.signup.confirmpassword.focus();
            return false;
        }
        return true;
    }
    </script>
    
    <script>
    function checkAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check_availability.php",
            data: 'emailid=' + $("#emailid").val(),
            type: "POST",
            success: function(data) {
                $("#user-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
    </script>
</head>

<body>
    <?php include('includes/header.php');?>

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line" style="color: var(--e-global-color-primary);">User Signup</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <div class="panel panel-danger">
                        <div class="panel-heading" style="background-color: var(--e-global-color-primary);">
                            SIGNUP FORM
                        </div>
                        <div class="panel-body">
                            <form name="signup" method="post" onSubmit="return valid();">
                                <div class="form-group">
                                    <label style="color: var(--e-global-color-text);">Enter Full Name</label>
                                    <input class="form-control" type="text" name="fullanme" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label style="color: var(--e-global-color-text);">Mobile Number :</label>
                                    <input class="form-control" type="text" name="mobileno" maxlength="10" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label style="color: var(--e-global-color-text);">Enter Email</label>
                                    <input class="form-control" type="email" name="email" id="emailid" onBlur="checkAvailability()" autocomplete="off" required />
                                    <span id="user-availability-status" style="font-size:12px;"></span>
                                </div>

                                <div class="form-group">
                                    <label style="color: var(--e-global-color-text);">Enter Password</label>
                                    <input class="form-control" type="password" name="password" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label style="color: var(--e-global-color-text);">Confirm Password</label>
                                    <input class="form-control" type="password" name="confirmpassword" autocomplete="off" required />
                                </div>

                                <button type="submit" name="signup" class="btn btn-danger" id="submit" style="background-color: var(--e-global-color-accent);">Register Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
