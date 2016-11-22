<?php 

// Helper Functions START

function clean($string){

	// return htmlentities($string);
	if($string == ($_POST['email'])){

		return filter_var($string, FILTER_SANITIZE_EMAIL);

	} else{

		return filter_var($string, FILTER_SANITIZE_STRING);
		
	}

}

function redirect($location){

	return header("Location: {$location}");

}

function set_message($message){

	if (!empty($message)) {

		$_SESSION['message'] = $message;

	} else {

		$message = "";

	}
}

function display_message() {

	if(isset($_SESSION['message'])) {

		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
}

function token_generator(){

	$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
	return $token;
}

function validation_errors($error_message) {

	$error_message = <<<DELIMITER
					<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Warning! </strong>$error_message </div>
DELIMITER;

return $error_message; 
}

function email_exists($email) {

	$sql = "SELECT id FROM users WHERE email = '$email'";

	$result = query($sql);

	if(row_count($result) == 1 ) {
		return true;
	} else {

		return false;
	}

}


function username_exists($username) {

	$sql = "SELECT id FROM users WHERE username = '$username'";

	$result = query($sql);

	if(row_count($result) == 1 ) {

		return true;

	} else {

		return false;
	}
}



function send_email($email, $subject, $msg, $headers){

	return mail($email, $subject, $msg, $headers);

}



/*****************Validation functions******************/ 

function validate_user_registration(){

	$errors = []; 

	$min = 3; 
	$max = 20; 


	if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$first_name 		= clean($_POST['first_name']);
			$last_name	 		= clean($_POST['last_name']);
			$username	 		= clean($_POST['username']);
			$email		 		= clean($_POST['email']);
			$password	 		= clean($_POST['password']);
			$confirm_password	= clean($_POST['confirm_password']);
			
			if(strlen($first_name)< $min){
				
				$errors[] = "Your first name cannot be less than {$min} characters ";
			}	

			if(strlen($first_name) > $max){
				
				$errors[] = "Your first name cannot be more than {$max} characters ";
			}	

			if(strlen($last_name)< $min){
				
				$errors[] = "Your last name cannot be less than {$min} characters ";
			}

			if(strlen($last_name) > $max){
				
				$errors[] = "Your last name cannot be more than {$max} characters ";
			}		

			if(strlen($username)< $min){
				
				$errors[] = "Your username cannot be less than {$min} characters ";
			}

			if (username_exists($username)) {
				
				$errors[] = "Sorry that username already is registreret";

			}

			if(strlen($username) > $max){
				
				$errors[] = "Your username cannot be more than {$max} characters ";
			}

			if (email_exists($email)) {
				
				$errors[] = "Sorry that email already is registreret";

			}

			if(strlen($email) < $min){
				
				$errors[] = "Your email cannot be more than {$min} characters ";
			}

			if ($password !== $confirm_password) {
				$errors[] = "Your password fields do not match"; 
			}

			if (!empty($errors)) {
				foreach ($errors as $error) {
					
				echo validation_errors($error);

				}
			} else {

				if (register_user($first_name, $last_name, $username, $email, $password)) {

					set_message("<p class='bg-success text-center'> Please check your email or spam folder for an activation code link</p>");
					redirect("index.php"); 
					
				} else {

					set_message("<p class='bg-danger text-center'>Sorry we could not register the user. </p>");
					redirect("index.php"); 
				}
			}
		} // Post request
} // function

/***************** REGISTER USER FUNCTION  ******************/ 

function register_user($first_name, $last_name, $username, $email, $password) {

	$first_name = escape($first_name);
	$last_name 	= escape($last_name);
	$username 	= escape($username);
	$email 		= escape($email);
	$password 	= escape($password);


	if(email_exists($email)) {

		return false; 
	
	} else if (username_exists($username)) {
		return false;

	} else {

		$password = md5($password);

		$validation_code = md5($username + microtime());

		$sql = "INSERT INTO users(first_name, last_name, username, email, password, validation_code, active)";
		$sql .= " VALUES('$first_name','$last_name','$username','$email','$password','$validation_code', 0)";
		$result = query($sql);

		
		$subject = "Activation account";
		$msg = "Please click the link below to activate your account 

		http://localhost:8888/Edwad_diaz/exercise-files/activate.php?email=$email&code=$validation_code"; 

		$headers = "From: noreply@mywebsite.com"; 


		send_email($email, $subject, $msg, $headers);

		return true;
	}


} 

/***************** ACTIVATE USER FUNCTION  ******************/ 

function activate_user() {

	if($_SERVER['REQUEST_METHOD'] == "GET") {

		if(isset($_GET['email'])) {

			$email = clean($_GET['email']);
			$validation_code = clean($_GET['code']);

			$sql = "SELECT id FROM users WHERE email = '".escape($_GET['email'])."' AND validation_code = '" . escape($_GET['code'])."' ";
			$result = query($sql);
			confirm($result);


			if (row_count($result) == 1) {

				$sql2 = "UPDATE users SET active = 1, validation_code = 0 WHERE email = '".escape($email)."' AND validation_code = '".escape($validation_code)."'";
				$result2 = query($sql2);

				set_message ("<p class='bg-success'>Your account has been activated. Please login</p>");
				redirect("login.php");

			} else {

				set_message ("<p class='bg-danger'>Sorry, your account could not be activated</p>");
				redirect("login.php");
			}
			

		} 
	}
} // function


/***************** VALIDATE USER LOGIN FUNCTION  ******************/ 



function validate_user_login(){

	$errors = []; 

	$min = 3; 
	$max = 20; 


	if ($_SERVER['REQUEST_METHOD'] == "POST") { 

		$email		= clean($_POST['email']);
		$password 	= clean($_POST['password']);
		$remember 	= isset($_POST['remember']);

			if (empty($email)) {
				$errors[] = "Email field cannot be empty";
			}
			if (empty($password)) {
				$errors[] = "Password field cannot be empty";
			}			

			if (!empty($errors)) {
				foreach ($errors as $error) {
					
				echo validation_errors($error);

				}
			} else {
				
				if (login_user($email, $password, $remember)) {
					redirect("admin.php");
				} else {
					echo validation_errors("your credentials are not correct");
				}
			}
	}
} // function


/*****************  USER LOGIN FUNCTION  ******************/ 


function login_user($email, $password, $remember) { // Tjek email, password og cookie/session

	$sql = "SELECT password, id FROM users WHERE email = '".escape($email)."' AND active = 1";
	$result = query($sql); // undersøger om der er en match i databasen

	if (row_count($result) == 1) { // IF 1 THEN
	 	
	 	$row = mysqli_fetch_array($result); //Fetch data fra det ene der er fundet. 

	 	$db_password = $row['password']; // Lav password om til en variabel $db_password

	 	if (md5($password) === $db_password) { // sammenlign med md5 password og om det er det samme

	 		if ($remember == "on") { // hvis REMEMBER er on, så set cookie
	 			setcookie('email', $email, time() + 86400); //86400 sekunder skal cookien holde
	 		}

	 		$_SESSION['email'] = $email; // SPØRGSMÅL

	 		return true;
	 	}else {
	 		return false;
			}

	 	return true;

	 } else {

	 	return false;
	 }

} // end of function  


/*****************  LOGGED IN FUNCTION  ******************/ 

function logged_in(){

	if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
		return true; 
	} else {
		return false; 
	}
} // functions end


/*****************  RECOVER PASSWORD FUNCTION  ******************/ 

function recover_password() {

	if ($_SERVER['REQUEST_METHOD'] == "POST") { // IF something posted THEN

		if (isset($_SESSION['token']) && ($_POST['token']) === $_SESSION['token']) { // IF isset in token and === with SESSION token (SPØRGSMÅL)

			$email = clean($_POST['email']); // Rens email via clean funktion

			if(email_exists($email)){ // IF email eksistere THEN


				$validation_code = md5($email + microtime()); // Lav en validation code

				setcookie('temp_access_code', $validation_code, time()+900); // Set en cookie på temp_access_code

				$sql = "UPDATE users SET validation_code = '".escape($validation_code)."' WHERE email = '".escape($email)."'"; 
				$result = query($sql);  // Updatere sql databasen via query. 


				$subject = "Please reset your password";
				$message = "Here is your password reset code {$validation_code}

				CLICK here to reset your password http://localhost:8888/Edwad_diaz/exercise-files/code.php?email={$email}&code={$validation_code}

				"; 

			$headers = "From: noreply@@edwincodecollege.com";





			send_email($email, $subject, $message, $headers);




			set_message("<p class='bg-success text-center'>Please check your email or spam folder for a password reset code http://localhost:8888/Edwad_diaz/exercise-files/code.php?email={$email}&code={$validation_code}</p>");

			redirect("index.php"); 

				} else {

					echo validation_errors("This email does not exist");
				}
		

		} else {

			redirect('index.php');
		}
		// Tokens checks

			
		if (isset($_POST['cancel_submit'])) {

			redirect("login.php");
			
		}
	} // post request 


} // functions



/*****************  CODE VALIDATION ******************/ 

function validate_code() {

	if (isset($_COOKIE['temp_access_code'])) { // SPØRGSMÅL
				
					
			if (!isset($_GET['email']) && !isset($_GET['code'])) {

				redirect('index.php');
			
			} 
			elseif (empty($_GET['email']) || empty($_GET['code'])) {
				
				redirect('index.php');
			} else {

				if (isset($_POST['code'])) {	// tjekker url for value af CODE

					$email = clean($_GET['email']); // Renser email via clean funktion
					
					$validation_code = clean($_POST['code']); // renser code via clean funtion 

					$sql = "SELECT id FROM users WHERE validation_code = '".escape($validation_code)."' AND email = '".escape($email)."'";
					$result = query($sql);

					if (row_count($result) == 1) {
						
						setcookie('temp_access_code', $validation_code, time()+300); // SPØRGSMÅL

						redirect("reset.php?email=$email&code=$validation_code"); // SLETTES når mail virker

					} else {

						echo validation_errors("Sorry wrong validation code");
					}

				}
			}
		

	} else {

		set_message("<p class='bg-danger text-center'>Sorry, your validation code was expired</p>");	
		redirect("recover.php");

	}


} // End function


/*****************  PASSWORD RESET FUNCTION ******************/ 


function password_reset() {

	if (isset($_COOKIE['temp_access_code'])) { // SPØRGSMÅL

		if (isset($_GET['email']) && (isset($_GET['code']))) {
			if (isset($_SESSION['token']) && isset($_POST['token'])) {

				 if ($_POST['token'] === $_SESSION['token']) { // SPØRGSMÅL

				 	if ($_POST['password'] === $_POST['confirm_password']) { // true if it is same password

				 		$update_password = md5($_POST['password']); // Kryptere password til datasen

				 		$sql = "UPDATE users SET password = '".escape($update_password)."', validation_code = 0 WHERE email = '".escape($_GET['email'])."'";
				 		
				 		query($sql); //sendes til database
						
						set_message("<p class='bg-success text-center'>Your password is successfully updated. Please login. </p>");	
						
						redirect("login.php");

					} else {
						
						set_message("<p class='bg-danger text-center'>Password er IKKE ens </p>");	// ikke ens password
						
					}					
				}	
	
			} 

	} else {

		set_message("<p class='bg-danger text-center'>Sorry, your time has expired.  </p>");
		redirect("recover.php");
		}

}
}

















