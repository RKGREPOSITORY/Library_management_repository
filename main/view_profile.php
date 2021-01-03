<?php 
require_once "pdo.php";
require_once "util.php";
session_start();
 ?>


<!DOCTYPE html>
 <html>
 <head>
 	<title>Viewing Profile</title>
 	<?php require_once "head.php"; ?>
 </head>
 <body>
 <div class="container">
 <h1>Profile Information</h1>
<?php 
flashMessages();
$arr = array();
$stmt = $pdo->prepare("SELECT * FROM members  where member_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['member_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
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
$mid = $row['member_id'];
$em = $row['Email'];
$stmt = $pdo->prepare('SELECT issue_id, title, author, issue_date, return_date FROM books JOIN issue
			ON books.ISBN = issue.ISBN
			where member_id = :abc');

$stmt->execute(array(":abc" => $_GET['member_id']));

$x = 0;
$count = 0;
$issued;
$day = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
if(empty($row['issue_id']) === false){
	if ($x<1) {
        echo 'Issued Books :<br><table class="table">
        <thead>
        <tr>
            <th scope="col">Issue ID</th>
            <th scope="col">Title</th>
            <th scope="col">Author</th>
            <th scope="col">Issue Date</th>
            <th scope="col">Return Date</th>
            <th scope="col">Action</th>
        </tr>
    </thead><tbody>';
                $x++;
                
    }
    
}
$returnd = $row['return_date'];
$fined =  date("Y-m-d");
  $fined = substr($fined,0,10);
    $returnd = substr($returnd,0,10);
    $diff = strtotime($fined) - strtotime($returnd);
    if($diff > 0){
         $day+= ceil(abs($diff / 86400));
    }

echo '<tr>
        <th scope="row">';
echo(htmlentities($row['issue_id']));
array_push($arr, $row['issue_id']);
        echo('</th><td>');
        echo(htmlentities($row['title']));
        echo('</td><td>');
        echo(htmlentities($row['author']));
        echo('</td><td>');
        echo(htmlentities($row['issue_date']));
        echo('</td><td>');
        echo(htmlentities($row['return_date']));
        echo('</td><td>');
        echo('<a class="btn btn-danger" href="return_book.php?issue_id='.$row['issue_id'].'"role="button">Return</a>');
        echo('</td><td>');
echo "</tr>";

}
echo('</tbody><table>'); 

if($x != 0){
    echo "<h1> Fine = ";
    echo (htmlentities($day));
    echo("</h1>");

}
if ($day>0) {
    # code
     echo('<form method="POST">
         <input type="checkbox" id="c" name="c" value="Collected">
        <label for="c"> I have  Collected the Fine</label><br>
        <input type="submit" class="btn btn-success" name="pay" value="payfine">
        </form>');
 }

if(isset($_POST['pay'])){
      echo('<script>alert("Fine Paid Please Refresh The Page");
      </script>');
      for ($i=0; $i < count($arr); $i++) {
                renewBooks($pdo,$arr[$i]);
        }
    $day = 0;
    // header("Location: view_members.php");
}
echo "</br></p>";
if ($x != 0) {
 echo('<form method="POST">
        <input type="submit" class="btn btn-success" name="renew" value="Renew All">
        </form>');
}


 if (isset($_POST['renew'])){
        if($day > 0){
            echo('<script>alert("Pay Fine ");
      </script>');
        }
        else{
        for ($i=0; $i < count($arr); $i++) {
                renewBooks($pdo,$arr[$i]);
        }
        echo('<script>alert("Renew Successfully");
      </script>');
    }
}
  ?>
<a href="view_members.php">Done</a>
 </div>
 <?php require_once "tail.php"; ?>
 </body>
 </html>

 <!--
    if($day>0){
     echo('<form method="POST">
        <label for="fname">First name:</label>
        <input type="text" id="fname" name="fname" value="');
        echo (htmlentities($mid));

        echo('"><br><br>
        <label for="lemail">Email:</label>
        <input type="text" id="lemail" name="lemail" value="');
        echo(htmlentities($em));
        echo('"><br><br>
        <label for="aemail"> Admin Email:</label>
        <input type="text" id="aemail" name="aemail" required><br>
        <input type="checkbox" id="c" name="c" value="Collected">
        <label for="c"> I have  Collected the Fine</label><br>
        <input type="submit" class="btn btn-success" name="pay" value="Pay Fine">
        </form>
        <script>alert(" Fine Paid  ");
      </script>' );

}
-->
