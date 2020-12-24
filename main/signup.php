<?php
require_once 'pdo.php';
require_once 'util.php';

session_start();
    if ( isset($_POST['cancel']) ) {
        header('Location:login.php');
        return;
    }
    if(isset($_POST['submit'])){
           $msg = validatesignup();
	    if (is_string($msg)){
           $_SESSION['error'] = $msg;
            header("Location: signup.php");
                return;
        }
        $sql = "INSERT INTO pending_mem (FirstName, LastName, Position, Gender, Mobile,Email, College, Address,DOB)
                    VALUES (:fn, :ln, :po,:ge,:mo,:em, :co, :add, :dob)";
                    echo("<pre>\n".$sql."\n</pre>\n");

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':fn' => $_POST['fname'],
            ':ln' => $_POST['lname'],
            ':po' => $_POST['position'],
            ':ge' => $_POST['sex'],
            ':mo' => $_POST['mob'],
            ':em' => $_POST['email'],
            ':co' => $_POST['college'],
            ':add' => $_POST['address'],
            ':dob' => $_POST['dob'])
        );
        $_SESSION['success'] = "You Have Registerd Successfully";
        ?>
        <script>
            alert("Registration Suceessfull Email will be sent in within 2 days");
        </script>
    <?php
		header("Location: index.php");
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
    <div class="container" id="add_books">
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
                        <label for="fname" class="col-md-2 col-form-label">First Name</label>
                        <div class="col-md-10" >
                            <input type="text" name="fname" id="fname" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-md-2 col-form-label">Last Name</label>
                        <div class="col-md-10">
                            <input type="text" name="lname" id="lname" class="form-control" required>
                        </div>
                    </div>
                     <div class="form-group row">
                        <label for="position" class="col-md-4 col-form-label">Position/Education</label>
                        <div class="col-md-8">
                            <input type="text" name="position" id="position" class="form-control" required>
                        </div>
                    </div>
                     <div class="form-group row">
                        <label for="sex" class="col-md-2 col-form-label">Gender</label>
                        <select id="sex" name="sex" class="form-control">
                            <option selected name ="Gender">Gender</option>
                                <option value = "Male">Male</option>
                                  <option value="Female">Female</option>
                                  <option value="Trans">Transgender</option>
                                  </select>
                    </div>
                     <div class="form-group row">
                        <label for="mob" class="col-md-2 col-form-label">Mobile</label>
                        <div class="col-md-10">
                          <input type="text" name="mob" id="mob" required>
                        </div>
                    </div>
                     <div class="form-group row">
                        <label for="email" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                          <input type="email" name="email" id="email" required>
                        </div>
                    </div>
                    
                    

                    <div class="form-group row">
                        <label for="college" class="col-md-4 col-form-label">College/Orgnization</label>
                        <div class="col-md-8">
                            <input type="text" name="college" id="college" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-md-2 col-form-label">Address</label>
                        <div class="col-md-10">
                            <input type="address" name="address" id="address" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="dob" class="col-md-2 col-form-label">Date of Birth</label>
                        <div class="col-md-10">
                            <input type="date" name="dob" id="dob" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10">
                        <input type="submit" value="Submit" name="submit">
                        <input type="submit"value="cancel" name="cancel">
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<?php require_once "tail.php" ?>
</body>
</html>




