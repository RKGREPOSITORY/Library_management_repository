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
    if ( isset($_POST['ISBN']) && isset($_POST['member_id'])) {

      $msg = validateissue($pdo);
      if (is_string($msg)){
        $_SESSION['error'] = $msg;
        header('Location: issue_book.php?ISBN='.$_REQUEST['ISBN']);
        return;
    }
      header('Location: issue_conf.php?ISBN='.$_REQUEST['ISBN'].'&member_id='.$_POST['member_id']);
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
		          <a class="dropdown-item" href="renew_books.php">Renew Books</a>
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
    <div class="container" id="issue_books">
        <div class="row row-content">
            <div class="col-12">
                <h1>Issue Books</h1>
            </div>
            <div class="col-12 col-md-6">
                <?php 
                    flashMessages();
                ?>
                <form method="post">
                    <div class="form-group row">
                        <label for="title" class="col-md-2 col-form-label">ISBN</label>
                        <div class="col-md-10">
                            <input type="text" name="ISBN" id="ISBN" class="form-control" value="<?= $_REQUEST['ISBN'] ?>" required/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="title" class="col-md-2 col-form-label">Member ID</label>
                        <div class="col-md-10">
                            <input type="text" name="member_id" id="member_id" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10">
                        <input class="btn btn-primary" type="submit" value="Search" name="issue">
                        <input class="btn btn-secondary" type="submit" value="Cancel" name="cancel">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

  <?php require_once "tail.php" ?>
</body>
</html>