<?php 
    require_once "pdo.php";
    require_once "util.php";
    session_start();

    if ( isset($_POST['cancel']) ) {
        header('Location: index.php');
        return;
    }

    if(isset($_POST['check'])){
        $sql = "DELETE FROM books WHERE ISBN = :zip";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':zip' => $_GET['ISBN']));
        $_SESSION['success'] = 'Record deleted';
        echo '<script>alert("Book Deleted");
              window.location.replace("library.php");
            </script>';
        // header( 'Location: library.php' );
        return;
    }

    if ( ! isset($_GET['ISBN']) ) {
        $_SESSION['error'] = "Missing ISBN";
        header('Location: index.php');
        return;
    }

    $stmt = $pdo->prepare("SELECT * FROM books where ISBN = :xyz");
    $stmt->execute(array(":xyz" => $_GET['ISBN']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row === false ) {
        $_SESSION['error'] = 'Bad value for ISBN';
        header( 'Location: library.php' ) ;
        return;
    }
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Delete Books</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<?php require_once "head.php"; ?>
</head>
<body>
    <div class="container" id="delete_book">
        <?php 
            echo ('<h5><b>Member Details</b></h5>');
            echo '<h5><b>Book Details</b></h5>';
                    echo '<p>Title : '.$row['title'];
                    echo '</p><p>Author : '.$row['author'];
                    echo '</p><p>Price : '.$row['price'];
                    echo '</p><p>Publisher : '.$row['publisher'];
                    echo '</p><p>Description : '.$row['description'];
                    echo "</p>"; 


        ?>
    </div>
    <center>
        <form method="POST">
        <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="Checkbox" name="check">
        <label class="form-check-label" for="defaultCheck1">
            I want to Delete the mentioned Book
        </label>
        </div>
            <button type="submit" class="btn btn-danger">Delete</button>
            <button type="submit" class="btn btn-secondary" name="cancel">Cancel</button>
        </form>
    </center>
<?php require_once "tail.php" ?>
</body>
</html>
