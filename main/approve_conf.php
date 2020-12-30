<?php 
    require_once "pdo.php";
    require_once "util.php";
    session_start();

    if ( ! isset($_SESSION['user_id'])) {
        die( '<img src= "./img/access.jpg">');
    return;
    }

    if ( isset($_POST['cancel']) ) {
        header('Location: approve_members.php');
        return;
      }

        $stmt = $pdo->prepare("SELECT * FROM pending_mem  where request_id = :xyz");
        $stmt->execute(array(":xyz" => $_GET['request_id']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $fn = $row['FirstName'];
        $ln = $row['LastName'];
        $po = $row['Position'];
        $ge = $row['Gender'];
        $dob = $row['DOB'];
        $mo = $row['Mobile'];
        $em = $row['Email'];
        $co = $row['College'];
        $ad = $row['Address'];

    if(isset($_POST['check'])){
        $sql = "INSERT INTO members (FirstName, LastName, Position, Gender, Mobile, Email, College, Address, DOB)
                    VALUES(:fn, :ln, :pos, :gen, :mob, :em, :col, :ad, :dob)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':fn' => $fn,
            ':ln' => $ln,
            ':pos' => $po,
            ':gen' => $ge,
            ':mob' => $mo,
            ':em' => $em,
            ':col' => $co,
            ':ad' => $ad,
            ':dob' => $dob
        ));

        $stmt = $pdo->prepare("DELETE FROM pending_mem 
                                WHERE request_id = :rid");
        $stmt->execute(array(':rid'=> $_GET['request_id']));

        $_SESSION['success'] = "Member Approved";
      echo '<script>alert("Member Approved");
              window.location.replace("view_members.php");
            </script>';

    }
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

echo '<p>Name: '.$fn.' '.$ln;
echo '</p><p>Member ID: '.$row['request_id'];
echo '</p><p>Position: '.$po;
echo '</p><p>Gender: '.$ge;
echo '</p><p>Date of Birth:  '.$dob;
echo '</p><p>Mobile: '.$mo;
echo '</p><p>Email:  '.$em;
echo '</p><p>College:  '.$co;
echo '</p><p>Address: '.$ad;
echo "</p><p>";

echo "</br></p>";

 ?>
 <form method="POST">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="Checkbox" name="check">
            <label class="form-check-label" for="defaultCheck1">
              I want to Add the mentioned Member
            </label>
          </div>
              <button type="submit" class="btn btn-success">Approve</button>
              <button type="submit" class="btn btn-secondary" name="cancel">Cancel</button>
          </form>
 </div>
 <?php require_once "tail.php"; ?>
 </body>
 </html>