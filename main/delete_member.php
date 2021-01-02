<?php 
    require_once "pdo.php";
    require_once "util.php";
    session_start();

    if ( isset($_POST['cancel']) ) {
        header('Location: index.php');
        return;
    }

    if(isset($_POST['check'])){
        $sql = "DELETE FROM members WHERE member_id = :zip";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':zip' => $_GET['member_id']));
        $_SESSION['success'] = 'Record deleted';
        echo '<script>alert("Member Deleted");
              window.location.replace("library.php");
            </script>';
        // header( 'Location: library.php' );
        return;
    }

    if ( ! isset($_GET['member_id']) ) {
        $_SESSION['error'] = "Missing member_id";
        header('Location: index.php');
        return;
    }

    $stmt = $pdo->prepare("SELECT * FROM members where member_id = :xyz");
    $stmt->execute(array(":xyz" => $_GET['member_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row === false ) {
        $_SESSION['error'] = 'Bad value for member_id';
        header( 'Location: library.php' ) ;
        return;
    }
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Delete Members</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<?php require_once "head.php"; ?>
</head>
<body>
    <div class="container" id="delete_conf">
        <?php 
            echo ('<h5><b>Member Details</b></h5>');
            echo '<p>Name: '.$row['FirstName'].' '.$row['LastName'];
            echo '</p><p>Member ID: '.$row['member_id'];
            echo '</p><p>Position: '.$row['Position'];
            echo '</p><p>Gender: '.$row['Gender'];
            echo '</p><p>Date of Birth:  '.$row['DOB'];
            echo '</p><p>Mobile: '.$row['Mobile'];
            echo '</p><p>Email:  '.$row['Email'];
            echo '</p><p>College:  '.$row['College'];
            echo '</p><p>Address: '.$row['Address'];
            echo "</p><p>"; 


        ?>
    </div>
    <center>
          <form method="POST">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="Checkbox" name="check">
            <label class="form-check-label" for="defaultCheck1">
              I want to Delete the mentioned Member
            </label>
          </div>
              <button type="submit" class="btn btn-danger">Delete</button>
              <button type="submit" class="btn btn-secondary" name="cancel">Cancel</button>
          </form>
          </center>
<?php require_once "tail.php" ?>
</body>
</html>
