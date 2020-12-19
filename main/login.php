<?php
require_once 'pdo.php';
require_once 'util.php';

session_start();
unset($_SESSION['name']);
unset($_SESSION['user_id']);

if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;
}
$salt = 'XyZzy12*_';

if ( isset($_POST['email']) && isset($_POST["pass"]) ) {
    if( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION["error"] = "Email and password are required";
        header( 'Location: login.php' ) ; 
        error_log("Login fail ".$_SESSION['name'] );
        return;
    }

    $check = hash('md5', $salt.$_POST['pass']);

    $stmt = $pdo->prepare('SELECT user_id, name FROM users
        WHERE email = :em AND password = :pw');
    $stmt->execute(array(':em' => $_POST['email'], ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo ($check);
    if ($row !== false) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        header('Location: library.php');
        return;
    } else {
        $_SESSION["error"] = "Incorrect password.";
        header( 'Location: login.php' ) ; 
        // error_log("Login fail ".$_SESSION['name']." $check");
        return;
    }   
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<?php require_once "head.php"; ?>
</head>

<body>
	<div class="container">
		<h1>Log In Here</h1>
		<?php
	    	flashMessages();
		?>
		<form method="POST">
		<label for="nam">Email</label>
		<input type="text" name="email" id="email"><br/>
		<label for="id_1723">Password</label>
		<input type="password" name="pass" id="id_1723"><br/>
		<input type="submit" onclick="return doValidate();" value="Log In">
		<a href="index.php">Cancel</a>
		</form>
		<p>
		<a href="index.php">Back to Home Page</a>
	</div>
	<?php require_once "tail.php" ?>
</body>
</html>