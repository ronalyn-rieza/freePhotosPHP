<?php
    include("admin_includes/admin_header.php");
?>
<title>freePhotos.io - Add User</title>
<?php
    include("admin_includes/admin_nav.php");
?>

 <!-- add user  -->
<section id="add-user" class="">
    <div class="container">
        <div class="row">
             <div class="col-md-8 m-auto py-4">
                <div class="card mt-4">
                    <div class="card-header px-5 py-4">
                       <?php

                        display_message();

                           $errors = [];

	if(isset($_POST['add_user'])) {

		$first_name 		= clean($_POST['first_name']);
		$last_name 			= clean($_POST['last_name']);
		$email 				= clean($_POST['email']);
		$password			= clean($_POST['password']);
		$confirm_password	= clean($_POST['confirm_password']);


		if(email_exists($email)){

			$errors[] = "E-mail is already registered";

		}


		if($password !== $confirm_password) {

			$errors[] = "Password fields are not matched";

		}

          if(!empty($errors)){

            foreach ($errors as $error){

              echo validation_errors($error);
            }

          }else {

                $f_name = escape($first_name);
	            $l_name  = escape($last_name);
	            $user_email      = escape($email);
	            $password   = escape($password);

                $code_one = md5($email . microtime());

                $code_two = 0;

                $user_image = '';

                $user_role = 'Subscriber';

                $active = 1;

                $time_online = 0;

	           if(email_exists($email)) {

		          return false;

	           } else {

                   $password   = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

                    $query = query("INSERT INTO users(user_firstname, user_lastname, user_image, user_email, user_password, user_role, time_online, code_one, code_two, active) VALUES('$f_name', '$l_name', '$user_image', '$user_email', '$password', '$user_role', $time_online, '$code_one', '$code_two', $active)");

                    $old = ["'"];

                    $new = ["''"];
                    //escape single qoute before saving to data base
                    $query = str_replace($old, $new, $query);

                    confirm($query);

				    set_message("<p class='text-center py-2 mt-4 text-dark displyed-message-success'>New user has been added</p>");

                    redirect("users.php");

                }
		  }

    }// end of post add user
?>

                            <h3>Add User</h3>

                    </div>
                    <div class="card-body my-3">
                    <form id="add-user" method="post" action="" role="form">
                                <div class="form-group">
                                    <label for="fname" class="text-muted">Firstname:</label>
                                    <input type="text" name="first_name" id="fname" pattern="^[a-zA-Z ,\.'\-]{2,20}$" title="Must contain at least 2 and no more than 20 characters, no numbers and can only use . , ' - as special characters." class="form-control fl-cap form-control-input" value="<?php echo getPost("first_name"); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="lname" class="text-muted">Lastname:</label>
                                    <input type="text" name="last_name" id="lname" pattern="^[a-zA-Z ,\.'\-]{2,20}$" title="Must contain at least 2 and no more than 20 characters, no numbers and can only use . , ' - as special characters." class="form-control fl-cap form-control-input" value="<?php echo getPost("last_name"); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="text-muted">E-mail:</label>
                                    <input type="email" name="email" id="email" pattern="^(?!.*\.\.)[\w.\-#!$%&'*+\/=?^_`{}|~]{1,64}@[\w.\-]+\.[a-zA-Z]{2,3}$" title="example@mail.com" class="form-control form-control-input" value="<?php echo getPost("email"); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-muted">Password:</label>
                                    <input type="password" name="password" id="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[~!@#$%^&*()\-+=?\/<>|[\]{}_ :;\.,`]).{8,15}$" title="Must at least have 8 and no more than 15 characters containing a number, an uppercase and lowercase letter and use one of these special characters ~!@#$%^&*()-+=?/<>|[]{}_ :;.,`" class="form-control form-control-input" value="<?php echo getPost("password"); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="cpassword" class="text-muted">Confirm Password:</label>
                                    <input type="password" name="confirm_password" id="cpassword" class="form-control form-control-input" value="<?php echo getPost("confirm_password"); ?>" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
				                            <input type="submit" name="add_user" id="register-submit" class="form-control btn-outline-info mt-3" value="Submit">
				                        </div>
				                        <div class="col-md-6">
				                            <a class="btn btn-outline-dark form-control mt-3" href="users.php">Cancel</a>
				                        </div>
				                    </div>
				                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    include("admin_includes/admin_close_tags.php");
