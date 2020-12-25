<?php 
require_once "pdo.php";
require_once "util.php";
    session_start();
    if ( ! isset($_SESSION['user_id'])) {
    	die( '<img src= "./img/access.jpg">');
    return;
    }
    
    
	 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Library</title>
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
                <a class="nav-link" href="#">Home</span></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="search_books.php">Search Books</span></a>
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
  <?php 
    $sql = "SELECT * FROM books";
    $stmt = $pdo->query($sql);
        echo('<table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ISBN</th>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Price</th>
                        <th scope="col">Publisher</th>
                        <th scope="col">Available Copy</th>
                    </tr>
                </thead><tbody>');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo('<tr>
                <th scope="row">');
        echo(htmlentities($row['ISBN']));
        echo('</th><td>');
        echo(htmlentities($row['title']));
        echo('</td><td>');
        echo(htmlentities($row['author']));
        echo('</td><td>');
        echo(htmlentities($row['price']));
        echo('</td><td>');
        echo(htmlentities($row['publisher']));
        echo('</td><td>');
        echo(htmlentities($row['available']));
        echo('</td></tr>');
    }
    echo('</tbody><table>'); 

  ?>
	<?php require_once "tail.php" ?>
</body>
</html>