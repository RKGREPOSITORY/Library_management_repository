<?php 
	require_once "pdo.php";

	function flashMessages() {

		if (isset($_SESSION['success'])) {
		echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
		unset($_SESSION['success']);
		}

		if (isset($_SESSION['error'])) {
		echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
		unset($_SESSION['error']);
		}
	}

	function validatebooks() {
		if (strlen($_POST['title']) < 1 || strlen($_POST['author']) < 1 ||strlen($_POST['price']) < 1 ||strlen($_POST['publisher']) < 1 ||strlen($_POST['description']) < 1  ||strlen($_POST['available']) < 1 ) {
        	return "All fields are required";
		}

		if (is_float($_POST['price']) && is_numeric($_POST['available'])){
			return "Price & available no must be float & numeric respectively";
		}
		
    	return true;
	}
    function validatesignup() {
        if((strlen($_POST['mob']) != 10)){
            ?>
            <script>
                alert("KKK");
            </script>
              <?php
        	   return "Mobile No should be of 10 Digits";
		}
        
       $emailq = "SELECT Email FROM members";
		$stn = $pdo->query($emailq);
		while($ro = $stn->fetch(PDO::FETCH_ASSOC)){
			if $ro['Email'] == $_POST['email']{
				return "Email Id already Exists !!!"
			}
		}

		
    	return true;
	}
?>