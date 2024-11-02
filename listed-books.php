<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
{   
    header('location:index.php');
}
else{ 

    // Check if the form is submitted
    if(isset($_POST['submit'])){
        // Check if any books were selected
        if(!empty($_POST['selected_books'])){
            $selected_books = $_POST['selected_books'];
            $user_id = $_SESSION['login']; // Assuming user's session login holds user id or some unique identifier

            foreach($selected_books as $book_id){
                // First check if the book is still available and not selected by another user
                $sql_check = "SELECT isIssued FROM tblbooks WHERE id=:bookid";
                $query_check = $dbh->prepare($sql_check);
                $query_check->bindParam(':bookid', $book_id, PDO::PARAM_INT);
                $query_check->execute();
                $result_check = $query_check->fetch(PDO::FETCH_OBJ);

                if($result_check->isIssued == '0'){ // If the book is not issued yet
                    // Mark the book as issued immediately to prevent others from selecting
                    $sql_update = "UPDATE tblbooks SET isIssued='1' WHERE id=:bookid";
                    $query_update = $dbh->prepare($sql_update);
                    $query_update->bindParam(':bookid', $book_id, PDO::PARAM_INT);
                    $query_update->execute();

                    // Additional logic to issue the book to the user can go here
                    echo "Book ID " . htmlentities($book_id) . " has been successfully selected by you.<br>";
                } else {
                    echo "Sorry, Book ID " . htmlentities($book_id) . " has already been issued or selected by another user.<br>";
                }
            }
        } else {
            echo "No book selected.";
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
    <title>Online Library Management System |  Issued Books</title>
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

        <!-- Search Form -->
        <form method="post" action="">
            <div class="row">
                <div class="col-md-8">
                    <input type="text" name="searchTerm" class="form-control" placeholder="Search by book title, author, or category">
                </div>
                <div class="col-md-4">
                    <button type="submit" name="search" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>

        <br>

        <form method="post" action="">
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Available Books
                        </div>
                        <div class="panel-body">
                        
                        <?php
                        // Search Query
                        $searchTerm = '';
                        if(isset($_POST['search']) && !empty($_POST['searchTerm'])){
                            $searchTerm = $_POST['searchTerm'];
                            $sql = "SELECT tblbooks.BookName, tblcategory.CategoryName, tblauthors.AuthorName, tblbooks.ISBNNumber, tblbooks.BookPrice, tblbooks.id as bookid, tblbooks.bookImage, tblbooks.isIssued 
                                    FROM tblbooks 
                                    JOIN tblcategory ON tblcategory.id=tblbooks.CatId 
                                    JOIN tblauthors ON tblauthors.id=tblbooks.AuthorId 
                                    WHERE (tblbooks.BookName LIKE :searchTerm 
                                    OR tblcategory.CategoryName LIKE :searchTerm 
                                    OR tblauthors.AuthorName LIKE :searchTerm)";
                            $query = $dbh->prepare($sql);
                            $query->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
                        } else {
                            // Default Query
                            $sql = "SELECT tblbooks.BookName, tblcategory.CategoryName, tblauthors.AuthorName, tblbooks.ISBNNumber, tblbooks.BookPrice, tblbooks.id as bookid, tblbooks.bookImage, tblbooks.isIssued 
                                    FROM tblbooks 
                                    JOIN tblcategory ON tblcategory.id=tblbooks.CatId 
                                    JOIN tblauthors ON tblauthors.id=tblbooks.AuthorId";
                            $query = $dbh->prepare($sql);
                        }
                        
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if($query->rowCount() > 0)
                        {
                            foreach($results as $result)
                            {   
                                ?>  
                                <div class="col-md-4" style="float:left; height:300px;">   

                                    <!-- Book Image and Info -->
                                    <img src="admin/bookimg/<?php echo htmlentities($result->bookImage);?>" width="100">
                                    <br /><b><?php echo htmlentities($result->BookName);?></b><br />
                                    <?php echo htmlentities($result->CategoryName);?><br />
                                    <?php echo htmlentities($result->AuthorName);?><br />
                                    <?php echo htmlentities($result->ISBNNumber);?><br />

                                    <?php if($result->isIssued=='0'): ?>
                                        <!-- Checkbox for selecting the book if not issued -->
                                        <input type="checkbox" name="selected_books[]" value="<?php echo htmlentities($result->bookid); ?>"> Select this book
                                    <?php else: ?>
                                        <p style="color:red;">Book Already issued</p>
                                    <?php endif; ?>

                                </div>
                                <?php 
                                $cnt=$cnt+1;
                            }
                        } 
                        ?>  
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" name="submit" class="btn btn-success">Submit Selected Books</button>
                </div>
            </div>

        </form>

    </div>
</div>

     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>

</body>
</html>
<?php } ?>
