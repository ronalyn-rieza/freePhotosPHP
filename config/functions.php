<?php

/****************helper functions ********************/
/*==cleaning string before saving into db ====*/
function clean($string) {
    return htmlentities($string);
}
/*=========================================*/
/* == redirecting to a page ===============*/
function redirect($location){
    return header("Location: {$location}");
    exit;
}
/*=========================================*/
/*============ keep the form input value when it didn't pass the validation ====*/
function getPost($field){
   return (isset($_POST[$field]) && $_POST[$field] != "" ? $_POST[$field] : "");
}
/*=====================================================================*/
/* ===== setting session message ==========*/
function set_message($message) {
	if(!empty($message)){
		$_SESSION['message'] = $message;
	}else {
		$message = "";
	}
}
/*========================================*/
/* === displaying session message ========*/
function display_message(){
	if(isset($_SESSION['message'])) {
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
}
/*========================================*/
/*=== setting token session ==============*/
function token_generator(){
    $token = $_SESSION['token'] =  md5(uniqid(mt_rand(), true));
    return $token;
}
/*=========================================*/
/*=== validation errors message alert======*/
function validation_errors($error_message) {
$error_message = <<<DELIMITER

<div class="warning">
	<p class="warning__content">$error_message</p>
	<span class="warning__close">X</span>
</div>

DELIMITER;
return $error_message;
}
/*=========================================*/
/*== checking if email exist in users table on db ===*/
function email_exists($email){
	$result = query("SELECT user_email FROM users WHERE user_email = '".escape($email)."'");
  confirm($result);
	if(row_count($result) > 0 ) {
		return true;
	} else {
		return false;
	}
}
/*===================================================*/
/*===== sending email ==================================*/
function send_email($email, $subject, $msg, $headers){
    return mail($email, $subject, $msg, $headers);
}
/*======================================================*/
/****************Validation functions ********************/
function validate_user_registration(){
	$errors = [];
	if(isset($_POST['register_submit'])) {
		$first_name 		= clean($_POST['first_name']);
		$last_name 			= clean($_POST['last_name']);
		$email 				= clean($_POST['email']);
		$password			= clean($_POST['password']);
		$confirm_password	= clean($_POST['confirm_password']);

		if(email_exists($email)){
			$errors[] = "E-mail is already registered. Please use different E-mail or <a class='btn btn__small-primary' href='login.php'>Login</a>";
		}

		if($password !== $confirm_password) {
			$errors[] = "Password fields are not matched";
		}

              if(!empty($errors)){
                    foreach ($errors as $error){
                      echo validation_errors($error);
                    }
              }else {

                $firstName = escape($first_name);
                $lastName  = escape($last_name);
                $userEmail = escape($email);
                $passWord   = escape($password);

                $Password   = password_hash($passWord, PASSWORD_BCRYPT, array('cost'=>12));

                $code_one = md5($email . microtime());

                $code_two = md5($password . microtime());

                $user_image = '';

                $user_role = 'Subscriber';

                $active = 0;

                $time_online = 0;

                $query = query("INSERT INTO users(user_firstname, user_lastname, user_image, user_email, user_password, user_role, time_online, code_one, code_two, active) VALUES('$firstName', '$lastName', '$user_image', '$userEmail', '$Password', '$user_role', $time_online, '$code_one', '$code_two', $active)");

                $old = ["'"];

                $new = ["''"];

                $query = str_replace($old, $new, $query);

                confirm($query);

                $subject = "Activate Account";

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
                $headers .= "From: noreply@freephotos.io". "\r\n";

                //$template = "<div style='padding:50px;'><p>Hello $first_name</p><p>Thank you...! For Signing Up to our Website.</p><p>Please click the link below to activate your Account</p><a href='https://www.freephotos.io/index.php?code=$code_one&valcode=$code_two'>https://www.freephotos.io/index.php?code=$code_one&valcode=$code_two</a></div>";
                $template = "<div style='padding:50px;'><p>Hello $first_name</p><p>Thank you...! For Signing Up to our Website.</p><p>Please click the link below to activate your Account</p><a href='http://localhost/free-photos-website/index.php?code=$code_one&valcode=$code_two'>http://localhost/free-photos-website/index.php?code=$code_one&valcode=$code_two</a></div>";
                $sendmessage = "<div>" . $template . "</div>";

                send_email($email, $subject, $sendmessage, $headers);

                set_message("<p class='bg-primary message message-small'>Thank you...! For Signing Up to our Website. Please check your email to activate your account.</p>");

                redirect("register.php");

            }//no errors else closing brackets

    }// post request

} // function
/*==========================================================*/

/****************Activate user functions ********************/
function activate_user() {

	if($_SERVER['REQUEST_METHOD'] == "GET") {

		if(isset($_GET['code']) && isset($_GET['valcode'])) {

			$code_one = clean($_GET['code']);

			$code_two = clean($_GET['valcode']);

			$sql = "SELECT user_id FROM users WHERE code_one = '".escape($code_one)."' AND code_two = '".escape($code_two)."' AND active = 0 AND time_online = 0";

			$result = query($sql);

            confirm($result);

			if(row_count($result) === 1) {

                $active = 1;

                $stmt = query_stmt("UPDATE users SET active = ?, code_two = 0 WHERE code_one = ? AND time_online = 0");

                mysqli_stmt_bind_param($stmt, "is", $active, $code_one);

                mysqli_stmt_execute($stmt);

                confirm($stmt);

                set_message("<p class='bg-primary message message-small'>Your account has been activated please login</p>");

			          redirect("login.php");

            } else {

        			 set_message("<p class='mb-large bg-secondary message'>Activation code is invalid - Check your email for validation code and Try again</p>");

        			 redirect("index.php");

            }//row count
        }//if get is set
    }// sever request method
} // function
/*================================================================*/

/****************Validate user login functions ********************/
function validate_user_login(){

    if(isset($_POST['login_submit'])){

		$login_email      =   clean($_POST['login_email']);
		$login_password   =   clean($_POST['login_password']);
    //$remember   = clean($_POST['remember']);

      $sql = "SELECT user_password, user_role, user_id FROM users WHERE user_email = '".escape($login_email)."' AND active = 1 AND code_one != ''";

		  $result = query($sql);

      confirm($result);

		  if(row_count($result) > 0) {

			     $row = fetch_array($result);

			     $db_password = $row['user_password'];

           $db_userrole = $row['user_role'];

           $db_user_id  = $row['user_id'];

            if(password_verify($login_password, $db_password)) {

                $time = time();

                $online_sql = "UPDATE users SET time_online = $time WHERE user_id = $db_user_id AND code_one != '' ";

                $user_online = query($online_sql);

                confirm($user_online);

        				if(isset($_POST['remember']) || $_POST['remember'] == 'on') {
                  //setcookie('user', $db_user_id, time() + 60*60*24, '/', 'freephotos.io', TRUE, TRUE);
                  //setcookie('role', $db_userrole, time() + 60*60*24, '/', 'freephotos.io', TRUE, TRUE);
                  setcookie('user', $db_user_id, time() + 60*60*24, '/', '', FALSE, FALSE);
                  setcookie('role', $db_userrole, time() + 60*60*24, '/', '', FALSE, FALSE);
        				}

                $_SESSION['user_role'] = $db_userrole;

                $_SESSION['user'] = $db_user_id;

                if($db_userrole === 'Admin'){
                   redirect("admin/dashboard.php");
                }else{
                     redirect("home.php");
                }//user role = admin else closing brackets

          } else {

              echo validation_errors("Email or Password that you've entered is incorrect");

          }//password verify else closing brackets

        }else{

            $sql = "SELECT code_one, code_two FROM users WHERE user_email = '".escape($login_email)."' AND active = 0 AND code_one != ''";

            $result = query($sql);

            confirm($result);

            if(row_count($result) === 1) {

                $row = fetch_array($result);

                $db_code_one = $row['code_one'];

                $db_code_two = $row['code_two'];

                $subject = "Activate Account";

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
                $headers .= "From: noreply@freephotos.io". "\r\n";

                //$template = "<div style='padding:50px;'><p>Thank you...! For Signing Up to our Website.</p><p>Please click the link below to activate your Account</p><a href='https://www.freephotos.io/index.php?code=$db_code_one&valcode=$db_code_two'>https://www.freephotos.io/index.php?code=$db_code_one&valcode=$db_code_two</a></div>";
                $template = "<div style='padding:50px;'><p>Thank you...! For Signing Up to our Website.</p><p>Please click the link below to activate your Account</p><a href='http://localhost/free-photos-website/index.php?code=$db_code_one&valcode=$db_code_two'>http://localhost/free-photos-website/index.php?code=$db_code_one&valcode=$db_code_two</a></div>";
                $sendmessage = "<div>" . $template . "</div>";

                send_email($email, $subject, $sendmessage, $headers);

                set_message("<p class='bg-secondary message message-small'>Your account is not activated yet - Check your email for activation link </p>");

                redirect("login.php");

            }else{

                set_message("<p class='bg-secondary message message-small'>No account found - Please sign up</p>");

                redirect("register.php");

            }//user active = 0 found else closing brackets

        }//user active = 1 found else closing brackets

    }// server request method

} // function
/*==============================================================================*/

/****************Recover Password function ********************/
function recover_password(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

		if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {

			$email = clean($_POST['email']);

			if(email_exists($email)) {

        $sql = "SELECT user_id, code_one FROM users WHERE user_email = '".escape($email)."' AND active = 1 AND code_one != ''";

        $result = query($sql);

        confirm($result);

            if(row_count($result) === 1) {

                $row = fetch_array($result);

                $db_code_one = $row['code_one'];

                $code_two = md5($email . microtime());

                //setcookie('temp_access_code', $code_two, time() + 60*60, '/', 'freephotos.io', TRUE, TRUE);
                setcookie('temp_access_code', $code_two, time() + 60*60, '/', '', FALSE, FALSE);

                $stmt = query_stmt("UPDATE users SET code_two = ? WHERE user_email = ? AND active = 1 AND code_one != ''");

                mysqli_stmt_bind_param($stmt, "ss", $code_two, $email);

                mysqli_stmt_execute($stmt);

                confirm($stmt);

                $subject = "Reset Password";

                 $headers = "MIME-Version: 1.0" . "\r\n";
                 $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
                 $headers .= "From: noreply@freephotos.io". "\r\n";

                 $template = "<div style='padding:50px;'><p>Please click the link below to reset your password</p><a href='http://localhost/free-photos-website/reset_password.php?code=$db_code_one&resetpcode=$code_two'>http://localhost/free-photos-website/reset_password.php?code=$db_code_one&resetpcode=$code_two</a></div>";
                 $sendmessage = "<div>" . $template . "</div>";

                 send_email($email, $subject, $sendmessage, $headers);

                 set_message("<p class='bg-primary message message-small'>Please check your email to reset your password</p>");

                 redirect("recover_password.php");

            }else{

                $sql = "SELECT code_one, code_two FROM users WHERE user_email = '".escape($email)."' AND active = 0 AND time_online = 0";

                $result = query($sql);

                confirm($result);

                if(row_count($result) === 1) {

                    $row = fetch_array($result);

                    $db_code_one = $row['code_one'];

                    $db_code_two = $row['code_two'];

                    $subject = "Activate Account";

                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
                    $headers .= "From: noreply@freephotos.io". "\r\n";

                    $template = "<div style='padding:50px;'><p>Thank you...! For Signing Up to our Website.</p><p>Please click the link below to activate your Account</p><a href='http://localhost/free-photos-website/index.php?code=$db_code_one&valcode=$db_code_two'>http://localhost/free-photos-website/index.php?code=$db_code_one&valcode=$db_code_two</a></div>";
                    $sendmessage = "<div>" . $template . "</div>";

                    send_email($email, $subject, $sendmessage, $headers);

                    set_message("<p class='bg-secondary message message-small'>Please activate your account to reset your password - Check your e-mail for activation link. </p>");

                    redirect("recover_password.php");

                }//row count active = 0 closing brackets

            }//result row count and active = 1 else closing brackets

			} else{

				echo validation_errors("The e-mail you've entered is not registered - Please try again");

			}//if email exist else closing brackets

		} else {

            redirect("index.php");

		}//session token and post token is = session token else closing brakets


    } // post request


} // functions
//=====================================================================/

/**************** validating recover password code ********************/
function validate_recover_password_code(){

    if(isset($_COOKIE['temp_access_code'])) {

        if(!isset($_GET['code']) && !isset($_GET['resetpcode'])) {

				    redirect("index.php");

			  } else if (empty($_GET['code']) || empty($_GET['resetpcode'])) {

				    redirect("index.php");

			  } else {

					$code_one = clean($_GET['code']);

					$code_two = clean($_GET['resetpcode']);

					$sql = "SELECT user_id FROM users WHERE code_two = '".escape($code_two)."'AND code_one = '".escape($code_one)."' AND active = 1";

					$result = query($sql);

          confirm($result);

					if(row_count($result) === 1) {

                if(isset($_POST['reset-submit'])){

                    $password = clean($_POST['password']);
                    $confirm_password = clean($_POST['confirm_password']);

                    $password = escape($password);
                    $confirm_password = escape($confirm_password);

                    if($password === $confirm_password){

                        $updated_password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

                        $stmt = query_stmt("UPDATE users SET user_password = ?, code_two = 0 WHERE code_one = ? AND active = 1");

                        mysqli_stmt_bind_param($stmt, "ss", $updated_password, $code_one);

                        mysqli_stmt_execute($stmt);

                        confirm($stmt);

                        set_message("<p class='bg-primary message message-small'>Your password has been updated - Please login</p>");

                        redirect("login.php");

  						      } else {

                        echo validation_errors("Password fields are not matched");

  						      }// if password = confirm password else closing brakets

                }//reset-submit closing brackets

						} else {

							set_message("<p class='bg-secondary message message-small'>Code to reset your password is invalid - Please try again</p>");

			        redirect("recover_password.php");

						}//if row count = 1 else closing brackets
      	}//isset mail and resetcode closing brackets

   }else {

    set_message("<p class='bg-secondary message message-small'>Code to reset your password is expired - Please try again</p>");

    redirect("recover_password.php");

   }//if isset cookie tempt access code else closing brackets

}//function closing brackets
/*=======================================================================*/

/*======= Sending and Recieving mail from users ====================================*/

function query_mail(){

    if(isset($_POST['contact_form_submit'])){

      $contact_name 		= clean($_POST['contact_name']);
  		$contact_email		= clean($_POST['contact_email']);
  		$contact_message 	= clean($_POST['contact_message']);

      $contactName 		= escape($contact_name);
  		$contactEmail		= escape($contact_email);
  		$contactMessage 	= escape($contact_message);

        //getting mail from user query
        $to = "downloadfreephotosio@gmail.com";
        $subjects = "Query from freephotos.io";

        $header = "MIME-Version: 1.0" . "\r\n";
        $header .= "Content-type: text/html; charset=UTF-8" . "\r\n";
        $header .= "From: " . $contactName . " <" . $contactEmail . ">". "\r\n";

        $templates = "<div style='padding:50px;'><p>". $contact_message . "</p></div>";
        $sendmsg = "<div>" . $templates . "</div>";

        mail($to,$subjects,$sendmsg,$header);

        set_message("<p class='mb-large bg-primary message'>Your Query has been sent, We will contact you As Soon As Possible</p>");

        $url = "http://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

        redirect($url);

        }

}//function closing brackets

//start of profile info function
function profile_info($user_id){

    $sql = "SELECT user_id, user_firstname, user_lastname, user_email, user_image FROM users WHERE user_id = '".escape($user_id)."' AND active = 1 AND time_online != 0";

    $result = query($sql);

    confirm($result);

     while($row = fetch_array($result)){

        $db_user_id = $row['user_id'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_email = $row['user_email'];
        $db_user_image = $row['user_image'];

        echo "<div class='profile__info'>";
          echo "<div class='profile__image'>";
	          // showing default image if there is no user image in database
	          if (empty($db_user_image)){

	               $image = "avatar.png";

	              echo "<img src='users-profile-photo/$image' alt='profile-avatar' class='profile-img'>";

	          }else{

	               echo "<img src='users-profile-photo/".$db_user_image."?".time()."' alt='profile-photo' class='profile-img'>";

	          }

	          if (!empty($db_user_image)){

	              echo "<a href='#' data-id='{$db_user_id}' class='profile__image--change-edit-photo open-modal delete-image'>Delete Photo</a>";
	          }

	          echo "<a href='edit_photo.php' class='profile__image--change-edit-photo'>Change Photo</a>";

          echo "</div>";
          echo "<hr>";
          echo "<div class='profile__about'>";
             echo "<p class='' id='name'><span class='text-muted'>First Name:</span> $db_user_firstname</p>";

             echo "<p class='' id='lname'><span class='text-muted'>Last Name:</span> $db_user_lastname</p>";

             echo "<p class='' id='email'><span class='text-muted'>E-mail:</span> $db_user_email</p>";

             echo "<a href='change_password.php' class='profile__info--change-pass'>Change Password</a>";
          echo "</div>";
          echo "</div>";
          echo "<div class='card__footer flex__button mt-medium'>";
            echo "<a href='#' data-id='{$db_user_id}' class='btn btn__primary flex__button-item open-modal edit-profile'>Edit Profile</a>";

            echo "<a href='#' data-id='{$db_user_id}' class='btn btn__secondary flex__button-item open-modal delete-account'>Delete Account</a>";
         	echo "</div>";

//saving new profile info into database
if(isset($_POST['save_profile_changes'])){

    $profile_fname = clean($_POST['profile_fname']);
    $profile_lname = clean($_POST['profile_lname']);
    $profile_email = clean($_POST['profile_email']);

    if($profile_fname == ""){
        $profile_fname = $db_user_firstname;
    }

    if($profile_lname == ""){
        $profile_lname = $db_user_lastname;
    }

    if($profile_email == ""){
        $profile_email = $db_user_email;
    }

        $first_name = escape($profile_fname);
        $last_name  = escape($profile_lname);
        $email      = escape($profile_email);

        $query = query("UPDATE users SET user_firstname = '$first_name', user_lastname = '$last_name', user_email = '$email' WHERE user_id = $user_id AND active = 1 AND time_online != 0");

        $old = ["'"];

        $new = ["''"];
        //escape single qoute before saving to database
        $query = str_replace($old, $new, $query);

        confirm($query);


        set_message("<p class='bg-primary message message-small'>Changes has been Saved</p>");

        redirect("profile.php");

      }//end of profile changed
    }//end of while loop
}//end of profile info function

//start of user edit profile pic
function edit_profile_pic($user_id){

    $sql = "SELECT user_id FROM users WHERE user_id = '".escape($user_id)."' AND active = 1 AND time_online != 0";

    $result = query($sql);

    confirm($result);

    $row = fetch_array($result);

    $db_user_id =  $row['user_id'];

    if(isset($_POST['edit_photo'])){

        $profile_photo = clean($_FILES['profile_image']['name']);
        $profile_photo_temp = clean($_FILES['profile_image']['tmp_name']);
        $fileSize = $_FILES["profile_image"]["size"]; // File size in bytes
        $kaboom = explode(".", $profile_photo); // Split file name into an array using the dot
        $fileExt = end($kaboom); //

        $error =[];

        if (!preg_match("/.(gif|jpg|png|jpeg)$/i", $profile_photo) ) {

            $errors[] = "Your image was not .gif, .jpg, .jpeg, or .png - Please try again";

            unlink($profile_photo_temp); // Remove the uploaded file from the PHP temp folder
        }

        if($fileSize > 2097152) { // if file size is larger than 2 Megabytes

            $errors[] = "Your image was larger than 2 Megabytes in size - Please try again";

            unlink($profile_photo_temp); // Remove the uploaded file from the PHP temp folder
        }

        if(!empty($errors)){

            foreach ($errors as $error){

                echo validation_errors($error);

            }

        }else{

            $moveResult = move_uploaded_file($profile_photo_temp, "users-profile-photo/org_".$db_user_id.".".$fileExt);

            if ($moveResult != true) {

                echo "<p class='bg-secondary message message-small'>Problem occur on uploading image - Please try again.</p>";

            }else{

                $new_name = $db_user_id.".".$fileExt;

                //temporary file path
                $target_file = "users-profile-photo/org_".$new_name;
                //resized file path
                $resize_file = "users-profile-photo/".$new_name;

                $w = 500;
                $h = 450;

                //resizing image
                resize_image($target_file,$w,$h,$fileExt,$resize_file);
                //  clean up image storage
                unlink($target_file);

                //getting and deleting the old profile pic if user image doesn't have the same file extention as the new uploaded profile image
                $get_user_old_img = query("SELECT user_image FROM users WHERE user_id = '".escape($user_id)."' AND active = 1 AND time_online != 0");

                confirm($get_user_old_img);

                $row = fetch_array($get_user_old_img);

								$old_user_image = $row['user_image'];

                if($old_user_image != ''){

									if($new_name != $old_user_image){

										$target_path = "users-profile-photo/". $old_user_image;

										unlink($target_path);
									}

              	}

                //saving the new profile pic
                $stmt = query_stmt("UPDATE users SET user_image = '".escape($new_name)."' WHERE user_id = ? AND active = 1 AND time_online != 0");

                mysqli_stmt_bind_param($stmt, "i", $user_id);

                mysqli_stmt_execute($stmt);

                confirm($stmt);

                set_message("<p class='bg-primary message message-small'>Your profile photo has been changed</p>");

                redirect("profile.php");

            }//move uploaded file success closing tag

        }//no error closing tag

    }// if isset POST closing tag

}//end of user edit profile pic function

//start of resizing image function
function resize_image($target_file,$w,$h,$fileExt,$resized_file){

    list($w_orig, $h_orig) = getimagesize($target_file);

    $scale_ratio = $w_orig / $h_orig;

    if (($w / $h) > $scale_ratio) {

        $w = floor($h * $scale_ratio);

    } else {

        $h = floor($w / $scale_ratio);
    }

    //checking the ext of the file
    $ext = strtolower($fileExt);

    if ($ext == "gif"){

        $img = imagecreatefromgif($target_file);

    } else if($ext == "png"){

        $img = imagecreatefrompng($target_file);

    } else{

        $img = imagecreatefromjpeg($target_file);
    }

    //create the resized file
    $tci = imagecreatetruecolor($w, $h);

    // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);


    //save the resized file to the target path
    if ($ext == "gif"){

        $resized_image = imagegif($tci, $resized_file);


    } else if($ext =="png"){

        $resized_image = imagepng($tci, $resized_file);


    } else {

        $resized_image = imagejpeg($tci, $resized_file, 80);

    }

    imagedestroy($img);
    imagedestroy($tci);

}
//end of resizing image function

//start of showing image like number function
function image_like($user_id,$image_id,$image_likes){

        $likes_sql = "SELECT like_id FROM likes WHERE user_id='".escape($user_id)."' AND image_id = $image_id";

        $find_likeId_count = query($likes_sql);

        confirm($find_likeId_count);

        $like_id_count = mysqli_num_rows($find_likeId_count);

        if($like_id_count === 1){

           echo "<p class='like__download--likes-link btn btn__small-dark disabled'>You <svg class='icon-smallest icon-light'><use xlink:href='sprite/sprite.svg#icon-heart-outlined'></use></svg> $image_likes</p>";

        }else{

           echo "<p id='$image_id' class='like__download--likes-link btn btn__small-secondary like'>$image_likes <svg class='icon-smallest icon-light'><use xlink:href='sprite/sprite.svg#icon-heart-outlined'></use></svg></p>";

        }
}//end of showing image like number function

//start of saving image like function
function save_image_like($user_id,$image_id){

    $stmt = query_stmt("SELECT like_id FROM likes WHERE user_id = ? AND image_id = ?");

    confirm($stmt);

        if(isset($stmt)){

            mysqli_stmt_bind_param($stmt, "ii", $user_id, $image_id);

            mysqli_stmt_execute($stmt);

            mysqli_stmt_bind_result($stmt, $like_id);

            mysqli_stmt_fetch($stmt);

        }

        $like_id_count = mysqli_stmt_num_rows($stmt);

            if($like_id_count < 1){

                $stmt = query_stmt("INSERT INTO likes(user_id, image_id) VALUES(?, ?)");

								if(isset($stmt)){

									mysqli_stmt_bind_param($stmt, "ii", $user_id, $image_id);

	                mysqli_stmt_execute($stmt);

	                confirm($stmt);
								}

                $stmt2 = query_stmt("UPDATE images SET image_likes = image_likes + 1 WHERE image_id = ?");

								if(isset($stmt)){

									mysqli_stmt_bind_param($stmt2, "i", $image_id);

	                mysqli_stmt_execute($stmt2);

	                confirm($stmt2);

								}

            }

}//end of saving image like function

//start of getting user role
function get_user_role($user_id){

    $sql = "SELECT user_role FROM users WHERE user_id = '".escape($user_id)."' AND active = 1 AND time_online != 0";

    $result = query($sql);

    confirm($result);

    $row = fetch_array($result);

    $db_userrole =  $row['user_role'];

        if($db_userrole === 'Admin'){

             redirect("admin/dashboard.php");

        }else if($db_userrole === 'Subscriber'){

            redirect("home.php");

       }
}//end of getting user role

//start of changing password function
function change_password($user_id){

    if(isset($_POST['change_password'])){

        $password = clean($_POST['password']);
        $cpassword = clean($_POST['confirm_password']);

        $password = escape($password);
        $cpassword = escape($cpassword);

        if($password === $cpassword){

            $updated_password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

            $stmt = query_stmt("UPDATE users SET user_password = ? WHERE user_id = ? AND active = 1 AND time_online != 0");

            mysqli_stmt_bind_param($stmt, "si", $updated_password, $user_id);

            mysqli_stmt_execute($stmt);

            confirm($stmt);

            set_message("<p class='bg-primary message message-small'>Your Password has been Updated</p>");

            redirect("profile.php");

        } else {

				echo validation_errors("Password fields are not Matched");

        }//passwoord = cpassword closing brackets

    }//$_POST change password

}//end of changing password function

//start of showing search bar to subcriber function
function get_user_role_search_bar($user_role){

    $userRole = escape($user_role);

    if($userRole === 'Subscriber'){

        echo "<form id='search-form' action='search.php' method='get' role='form'>";
            echo "<div class='nav__primary--content__search'>";
                echo "<input name='search' class='nav__primary--content__search-input' type='text' placeholder='Looking for...' required>";
                echo "<button name='submit' class='nav__primary--content__search-button' type='submit'>";
                    echo "<svg class='nav__primary--content__search-icon'><use xlink:href='sprite/sprite.svg#icon-magnifying-glass'></use></svg>";
                echo "</button>";
            echo "</div>";
        echo "</form>";
        echo "<hr>";
    }
}
//end of showing search bar to subcriber function
