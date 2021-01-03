<?php 
    require_once "pdo.php";
    require_once "util.php";
      session_start();
      if ( ! isset($_SESSION['user_id'])) {
          die( '<img src= "./img/access.jpg">');
      return;
      }
      
      if ( isset($_POST['cancel']) ) {
        header('Location: view_members.php');
        return;
      }

      if(isset($_POST['check'])) {

      }
?>

<!DOCTYPE html>
 <html>
 <head>
 	<title>Return Book</title>
 	<?php require_once "head.php"; ?>
 </head>
 <body>
 <div class="container">
 <h1>Return Book</h1>
 <?php 
flashMessages();
$stmt = $pdo->prepare("SELECT * FROM books JOIN issue ON books.ISBN = issue.ISBN WHERE issue_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['issue_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$ISBN = htmlentities($row['ISBN']);
$title = htmlentities($row['title']);
$author = htmlentities($row['author']);
$publisher = htmlentities($row['publisher']);
$available = htmlentities($row['available']);
$issue_date = htmlentities($row['issue_date']);
$member_id = htmlentities($row['member_id']);
$issue_id = htmlentities($_GET['issue_id']);

echo('<p>ISBN : '.$ISBN);
echo '</p><p>Title : '.$title;
echo '</p><p>Author : '.$author;
echo '</p><p>Publisher : '.$publisher;
echo '</p><p>Member ID : '.$member_id;
echo '</p><p>Issue Date : '.$issue_date;
echo '</p>';

?>

</div>
<center>
    <form method="POST">
        <input type="submit" class="btn btn-danger" name="return_books" value="Return">
        <input type="submit" class="btn btn-secondary" name="cancel" value="Cancel">
        </form>
</center>
<?php
    if (isset($_POST['return_books'])){
        $sql = 'INSERT INTO return_books (issue_id, ISBN, member_id, issue_date, return_date)
        VALUES(:isid, :isbn, :mid, :isd, now())';
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
      ':isid' => $issue_id,
      ':isbn' => $ISBN,
      ':mid' => $member_id,
      ':isd' => $issue_date)
      );

      $avail = $available+1;

      $bookq = 'UPDATE books
                SET available = :av where ISBN = :ISBN';
      $stmt = $pdo->prepare($bookq);
      $stmt->execute(array(
                ':ISBN' => $ISBN,
                ':av' => $avail));

      $deliss = 'DELETE FROM issue WHERE issue_id = :iid';
      $stmt = $pdo->prepare($deliss);
      $stmt->execute(array(
                ':iid' => $issue_id));
      $_SESSION['success'] = "Returned Successfully";
          echo('<script>alert("Returned Successfully");
          window.location.replace("library.php");
        </script>');
    }
?>
 <?php require_once "tail.php"; ?>
 </body>
 </html>