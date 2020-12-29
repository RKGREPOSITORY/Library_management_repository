<?php
require_once 'pdo.php';
require_once 'util.php';
session_start();
    if ( isset($_POST['cancel']) ) {
        header('Location:login.php');
        return;
    }
    if( isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['position']) && isset($_POST['gender']) && isset($_POST['mobile'])&& isset($_POST['email']) && isset($_POST['College'])&& isset($_POST['Address']) && isset($_POST['dob'])){
           $msg = validatesignup($pdo);
	    if (is_string($msg)){
           $_SESSION['error'] = $msg;
            header("Location: signup.php");
                return;
        }
        $sql = "INSERT INTO pending_mem (FirstName, LastName, Position, Gender, Mobile, Email, College, Address,DOB)
                    VALUES (:fn, :ln, :po,:ge,:mo,:em, :co, :ad, :dob)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':fn' => $_POST['fname'],
            ':ln' => $_POST['lname'],
            ':po' => $_POST['position'],
            ':ge' => $_POST['gender'],
            ':mo' => $_POST['mobile'],
            ':em' => $_POST['email'],
            ':co' => $_POST['College'],
            ':ad' => $_POST['Address'],
            ':dob' => $_POST['dob'])
        );
        $_SESSION['success'] = "You Have Registered Successfully";
        echo '<script>alert("You Have Registered Successfully !!!");
              window.location.replace("login.php");
            </script>';
		// header("Location: login.php");
		return;
    }
    
	 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<?php require_once "head.php"; ?>
</head>
<body>
    <div class="container" id="signup">
        <div class="row row-content">
            <div class="col-12">
                <h1>Sign Up/ Register</h1>
            </div>
            <div class="col-12 col-md-6">
                <?php 
                    flashMessages();
                ?>
                <form method="post">
                    <div class="form-group row">
                        <label for="fname" class="col-md-2 col-form-label">FirstName</label>
                        <div class="col-md-10">
                            <input type="text" name="fname" id="fname" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-md-2 col-form-label">LastName</label>
                        <div class="col-md-10">
                            <input type="text" name="lname" id="lname" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-md-2 col-form-label">Gender</label>
                        <div class="col-md-10">
                            <select id="sex" name="gender" class="form-control">
                            <option selected name ="gender">Gender</option>
                            <option value = "Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Trans">Transgender</option>
                    </select>
                        </div>
                    </div>

                    

                    <div class="form-group row">
                        <label for="position" class="col-md-2 col-form-label">Position</label>
                        <div class="col-md-10">
                            <input type="text" name="position" id="position" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mobile" class="col-md-2 col-form-label">Mobile</label>
                        <div class="col-md-10">
                            <input type="text" name="mobile" id="mobile" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-2 col-form-label">email</label>
                        <div class="col-md-10">
                            <input type="text" name="email" id="email" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="dob" class="col-md-2 col-form-label">Date of Birth</label>
                        <div class="col-md-10">
                            <input type="date" name="dob" id="dob" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="College" class="col-md-2 col-form-label">College</label>
                        <div class="col-md-10">
                            <input type="text" name="College" id="College" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Address" class="col-md-2 col-form-label">Address</label>
                        <div class="col-md-10">
                            <textarea name="Address" rows="5" cols="80" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="submit" class="btn btn-secondary" name="cancel">Cancel</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<?php require_once "tail.php" ?>
</body>
</html>
