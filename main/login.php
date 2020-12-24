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
        $_SESSION["error"] = "Incorrect email or password.";
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
	<div class="container" id="loginform">
		<div class="row row-content">
			<div class="col-12">
              <h1>Log In Here</h1>
           </div>
           <div class="col-12 col-md-6">
	           	<?php
		    		flashMessages();
				?>
				<form method="POST">

					<div class="form-group row">
						<label for="nam" class="col-md-2 col-form-label">Username</label>
						<div class="col-md-10">
							<input type="text" name="email" id="email" class="form-control">
						</div>
					</div>

					<div class="form-group row">
						<label for="id_1723" class="col-md-2 col-form-label">Password</label>
						<div class="col-md-10">
							<input type="password" name="pass" id="id_1723" class="form-control">
						</div>
					</div>

					<div class="form-group row">
						<!-- <div class="offset-md-2 col-md-10"> -->
							<input type="submit" onclick="return doValidate();" value="Log In">
							<a href="index.php">Cancel</a>
						<!-- </div> -->
					</div>
				</form>
				<p>
			<!-- Username is 'admin@php' and password is 'php123' -->
			<a href="index.php">Back to Home Page</a>
		</p>
           </div>
		</div>
	</div>
	<?php require_once "tail.php" ?>
</body>
</html>