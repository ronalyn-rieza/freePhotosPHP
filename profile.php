<?php
    include("includes/header.php");
?>
<title>freePhotos.io - Profile</title>
<?php
    include("includes/logedin_nav.php");
?>
<!-- profile section -->

<section id="profile" class="section">
  <div class="container">
    <div class="card card__medium">
      <h3 class="card__heading card__heading-medium">Profile</h3>
      <div class="warning-confirm__div">
        <?php
            display_message();
            query_mail();
       ?>
      </div>
      <?php
      // getting all the info that ass with session username in database
      if(isset($_SESSION['user'])){

          echo "<div class='col-md-3 mt-profile-pic mb-profile-pic'>";

          $user_id = abs((int)$_SESSION['user']);

          profile_info($user_id);


      }else if(isset($_COOKIE['user'])){

          echo "<div class='col-md-3 mt-profile-pic'>";//start of profile pic cookie user div

          $user_id = abs((int)$_COOKIE['user']);

          profile_info($user_id);

          }// end of cookie user and cookie set while loop
      ?>
    </div>
  </div><!--end of container div -->
</section>

<?php
//delete account
if(isset($_GET['delete'])){

        $get_delete_id = abs((int)$_GET['delete']);

        if($get_delete_id == $_SESSION['user'] || $get_delete_id == $_COOKIE['user']){

        //getting and deleting the profile pic
        $get_user_old_img = query("SELECT user_image FROM users WHERE user_id = '".escape($get_delete_id)."' AND active = 1 AND time_online != 0");

        confirm($get_user_old_img);

        $row = fetch_array($get_user_old_img);

        $target_path = 'users-profile-photo/' . $row['user_image'];

        unlink($target_path);


        $stmt = query_stmt("DELETE FROM users WHERE user_id = ? AND active = 1 AND time_online != 0");

        mysqli_stmt_bind_param($stmt, "i", $get_delete_id);

        mysqli_stmt_execute($stmt);

        confirm($stmt);

        if(isset($_COOKIE['user'])) {

            unset($_COOKIE['user']);

            setcookie('user', '', time()-60*60*24, '/', 'freephotos.io', TRUE, TRUE);

	      }

        if(isset($_COOKIE['role'])) {

      		unset($_COOKIE['role']);

      		setcookie('role', '', time()-60*60*24, '/', 'freephotos.io', TRUE, TRUE);

      	}
  
        if(isset($_COOKIE[session_name()])){
          session_destroy();
          $_SESSION = array();
          setcookie(session_name(), '', time()-3600, '/', 'freephotos.io', TRUE, TRUE);
        }

        set_message("<p class='mb-large bg-primary message'>We're Sorry to say Goodbye</p>");

        redirect("index.php");
    }
}

//delete profile photo
if(isset($_GET['deletepimage'])){

        $get_delete_id = abs((int)$_GET['deletepimage']);

        if($get_delete_id == $_SESSION['user'] || $get_delete_id == $_COOKIE['user']){

        //getting and deleting the profile pic
        $get_user_old_img = query("SELECT user_image FROM users WHERE user_id = '".escape($get_delete_id)."' AND active = 1 AND time_online != 0");

        confirm($get_user_old_img);

        $row = fetch_array($get_user_old_img);

        $target_path = 'users-profile-photo/' . $row['user_image'];

        unlink($target_path);

        //setting user image to null in database
        $stmt = query_stmt("UPDATE users SET user_image = null WHERE user_id = ? AND active = 1 AND time_online != 0");

        mysqli_stmt_bind_param($stmt, "i", $get_delete_id);

        mysqli_stmt_execute($stmt);

        confirm($stmt);

        set_message("<p class='bg-primary message message-small'>Profile photo has been deleted</p>");

        redirect("profile.php");

    }
  }

//footer - about and contact
 include("includes/footer.php");
?>
 <!-- =========================== -->
 <!--modals-->
 <div class="modal" id="">
    <div class="modal__content">

    </div>
</div>

  <!-- header closing tags-->

<?php include("includes/close_tags.php");
