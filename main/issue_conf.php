<?php 
  require_once "pdo.php";
  require_once "util.php";
    session_start();
    if ( ! isset($_SESSION['user_id'])) {
    	die( '<img src= "./img/access.jpg">');
    return;
    }
    
    if ( isset($_POST['cancel']) ) {
      header('Location: search_books.php');
      return;
    }

    if(isset($_POST['check'])){
      $sql= "INSERT INTO issue (ISBN, member_id, issue_date, return_date)
              VALUES (:ISBN, :mid, now(), date_add(now(),INTERVAL 1 MONTH))";

      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':ISBN' => $_GET['ISBN'],
        ':mid' => $_GET['member_id']
      ));

      $avail = calBookavaibility($pdo, $_GET['ISBN']);

      $sql = ('UPDATE books
                  SET available = :av where ISBN = :ISBN');
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
                  ':ISBN' => $_GET['ISBN'],
                  ':av' => $avail));

      $_SESSION['success'] = "Book Issued";
      echo '<script>alert("Book Issued");
              window.location.replace("library.php");
            </script>';
      // header("Location: library.php");
      return;
    }
    
    
?>

<!DOCTYPE html>
<html>
<head>
	<title>Issue Books</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<?php require_once "head.php"; ?>
</head>
<body>
	<nav class="navbar navbar-dark navbar-expand-lg fixed-top">
        <div class="container">
          <a class="navbar-brand mr-auto" href="#"><img src="img/logo.jpg" height="30" width="41"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" href="library.php">Home</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="search_books.php">Search Books</span></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="#">Issue Books</span></a>
              </li>
              <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Manage Books
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" href="add_books.php">Add Books</a>
		          <a class="dropdown-item" href="remove_books.php">Remove Books</a>
		           
		      </li>
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Manage Members
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" href="add_members.php">Add Member</a>
		          <a class="dropdown-item" href="remove_members.php">Remove Member</a>
		          <a class="dropdown-item" href="view_members.php">View Member</a>
		      </li>
            </ul>
            <span class="navbar-text">
                <a id="loginbutton" href="logout.php">Logout</a>
            </span>
          </div>
        </div>
  </nav>
    <div class="container" id="issue_conf">
        <div class="row row-content">
            <div class="col-12">
                <h1>Issue Books</h1>
            </div>
            <div class="col-12 col-md-6">
                <?php 
                    flashMessages();

                    //Book Details display
                    $stmt = $pdo->prepare("SELECT * FROM books where ISBN = :xyz");
                    $stmt->execute(array(":xyz" =>$_GET['ISBN']));
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo '<h5><b>Book Details</b></h5>';
                    echo '<p>Title : '.$row['title'];
                    echo '</p><p>Author : '.$row['author'];
                    echo '</p><p>Price : '.$row['price'];
                    echo '</p><p>Publisher : '.$row['publisher'];
                    echo '</p><p>Description : '.$row['description'];
                    echo "</p><p></div>";

                    echo '<div class="col-12 col-md-6">';

                    //Member Details Display
                    $stmt = $pdo->prepare("SELECT * FROM members where member_id = :abc");
                    $stmt->execute(array(":abc" =>$_GET['member_id']));
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo '<h5><b>Member Details</b></h5>';
                    echo '<p>Name : '.$row['FirstName'].' '.$row['LastName'];
                    // echo '</p><p>Position : '.$row['Position'];
                    echo '</p><p>Gender : '.$row['Gender'];
                    echo '</p><p>DOB : '.$row['DOB'];
                    echo '</p><p>Mobile : '.$row['Mobile'];
                    echo '</p><p>Email : '.$row['Email'];
                    echo "</p><p>";
                ?>

            </div>
        </div>
        <center>
          <form method="POST">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="Checkbox" name="check">
            <label class="form-check-label" for="defaultCheck1">
              I want to Issue the mentioned Book to mentioned Member
            </label>
          </div>
              <button type="submit" class="btn btn-success">Issue</button>
              <button type="submit" class="btn btn-secondary" name="cancel">Cancel</button>
          </form>
          </center>
    </div>

  <?php require_once "tail.php" ?>
</body>
</html>