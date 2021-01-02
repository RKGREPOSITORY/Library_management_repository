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
		
		if (!is_numeric($_POST['price']) || !is_numeric($_POST['available'])){
			return "Price & available no must be float & numeric respectively";
		}
		
    	return true;
	}

	function validate_edit_books() {
		if (strlen($_POST['title']) < 1 || strlen($_POST['author']) < 1 ||strlen($_POST['price']) < 1 ||strlen($_POST['publisher']) < 1 ||strlen($_POST['description']) < 1) {
        	return "All fields are required";
		}		
    	return true;
	}

	function validatemembers($pdo) {
		if (strlen($_POST['fname']) < 1 || strlen($_POST['lname']) < 1 ||strlen($_POST['position']) < 1 ||strlen($_POST['gender']) < 1 ||strlen($_POST['mobile']) < 1  ||strlen($_POST['email']) < 1 ||strlen($_POST['College']) < 1 ||strlen($_POST['Address']) < 1 ||strlen($_POST['dob']) < 1 ) {
        	return "All fields are required";
		}

		if (strpos($_POST['email'], '@') == false){
	        return 'Email must have an at-sign (@)';  
		}
		
		if((strlen($_POST['mobile']) != 10)){

			return "Mobile No should be of 10 Digits";
		}

		$emailq = "SELECT Email FROM members";
		$stn = $pdo->query($emailq);
		while($ro = $stn->fetch(PDO::FETCH_ASSOC)){
			if ($ro['Email'] == $_POST['email']){
				return "Email Id already Exists !!!";
			}
		}
    	return true;
	}

	function validate_edit_members() {
		if (strlen($_POST['fname']) < 1 || strlen($_POST['lname']) < 1 ||strlen($_POST['position']) < 1 ||strlen($_POST['gender']) < 1 ||strlen($_POST['mobile']) < 1  ||strlen($_POST['email']) < 1 ||strlen($_POST['College']) < 1 ||strlen($_POST['Address']) < 1 ||strlen($_POST['dob']) < 1 ) {
        	return "All fields are required";
		}

		if (strpos($_POST['email'], '@') == false){
	        return 'Email must have an at-sign (@)';  
		}
		
		if((strlen($_POST['mobile']) != 10)){

			return "Mobile No should be of 10 Digits";
		}
    	return true;
	}

	function validatesignup($pdo) {
		if (strlen($_POST['fname']) < 1 || strlen($_POST['lname']) < 1 ||strlen($_POST['position']) < 1 ||strlen($_POST['gender']) < 1 ||strlen($_POST['mobile']) < 1  ||strlen($_POST['email']) < 1 ||strlen($_POST['College']) < 1 ||strlen($_POST['Address']) < 1 ||strlen($_POST['dob']) < 1 ) {
        	return "All fields are required";
		}

		if (strpos($_POST['email'], '@') == false){
	        return 'Email must have an at-sign (@)';  
		}
		
		if((strlen($_POST['mobile']) != 10)){

			return "Mobile No should be of 10 Digits";
		}

		$emailq = "SELECT Email FROM members";
		$stn = $pdo->query($emailq);
		while($ro = $stn->fetch(PDO::FETCH_ASSOC)){
			if ($ro['Email'] == $_POST['email']){
				return "Email Id already Exists !!!";
			}
		}
		$emailr = "SELECT Email FROM pending_mem";
		$stn = $pdo->query($emailr);
		while($ro = $stn->fetch(PDO::FETCH_ASSOC)){
			if ($ro['Email'] == $_POST['email']){
				return "Email Id already Exists !!!";
			}
		}
    	return true;
	}

	function validateissue($pdo){
		if(strlen($_POST['ISBN'])<1 || strlen($_POST['member_id']<1)){
			return "All Fields are Required";
		}

		if(!is_numeric($_POST['ISBN']) || !is_numeric($_POST['member_id'])){
			return "All Field should be numeric";
		}

		$stn = $pdo->prepare('SELECT * FROM members where member_id= :mid');
		$stn->execute(array(':mid' => $_POST['member_id']));
		$ro = $stn->fetch(PDO::FETCH_ASSOC);
		if(empty($ro['Email'])){
			return "Member ID not valid";
		}

		$iss = "SELECT ISBN, member_id FROM issue";
		$stn = $pdo->query($iss);
		while($ro = $stn->fetch(PDO::FETCH_ASSOC)){
			if (($ro['ISBN'] == $_POST['ISBN'])&& ($ro['member_id'] == $_POST['member_id'])){
				return "Book already issued to same user !!!";
			}
		}

		return true;
	}

	function calBookavaibility($pdo, $ISBN) {
		$stn = $pdo->prepare('SELECT available FROM books where ISBN= :ISBN');
		$stn->execute(array(':ISBN' => $ISBN));
		$ro = $stn->fetch(PDO::FETCH_ASSOC);

		$avail = $ro['available'] - 1;

		return $avail;
	}

	function renewBooks($pdo, $issue_id) {
		$stmt = $pdo->prepare('UPDATE issue SET 
									return_date = date_add(now(),INTERVAL 1 MONTH);
									WHERE issue_id = :iid');
		$stmt->execute(array(
			':iid' => $issue_id
		));

		return true;
	}
	