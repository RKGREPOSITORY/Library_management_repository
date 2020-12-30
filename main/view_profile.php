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

$stmt = $pdo->prepare('SELECT issue_id, title, author, issue_date, return_date FROM books JOIN issue
			ON books.ISBN = issue.ISBN
			where member_id = :abc');

$stmt->execute(array(":abc" => $_GET['member_id']));
$i = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
if(empty($row['issue_id']) === false){
	if ($i<1) {
        echo 'Issued Books :<br><table class="table">
        <thead>
        <tr>
            <th scope="col">Issue ID</th>
            <th scope="col">Title</th>
            <th scope="col">Author</th>
            <th scope="col">Issue Date</th>
            <th scope="col">Return Date</th>
        </tr>
    </thead><tbody>';
		$i++;
    }
    
}

echo '<tr>
        <th scope="row">';
echo(htmlentities($row['issue_id']));
        echo('</th><td>');
        echo(htmlentities($row['title']));
        echo('</td><td>');
        echo(htmlentities($row['author']));
        echo('</td><td>');
        echo(htmlentities($row['issue_date']));
        echo('</td><td>');
        echo(htmlentities($row['return_date']));
        echo('</td><td>');
echo "</tr>";

}
echo('</tbody><table>'); 
echo "</br></p>";

 ?>
<a href="view_members.php">Done</a>
 </div>
 <?php require_once "tail.php"; ?>
 </body>
 </html>