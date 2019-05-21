<?php
    include("includes/header.php");
?>
<title>freePhotos.io - Change Password</title>
<?php
    include("includes/logedin_nav.php");
?>

 <!-- change password -->
 <section id="" class="section">
   <div class="container">
     <div class="card card__medium">
       <h3 class="card__heading card__heading-medium">Change Password</h3>
         <div class="warning-confirm__div">
           <?php
               if(isset($_SESSION['user'])){

                    $user_id = abs((int)$_SESSION['user']);

                    change_password($user_id);

                }else if(isset($_COOKIE['user'])){

                    $user_id = abs((int)$_COOKIE['user']);

                    change_password($user_id);

                }
           ?>
       </div>
       <form id="register-form" method="post" class="mt-medium" autocomplete="off" role="form">
            <label for="password" class="text-muted form__effect">Enter your new password:</label>
         <div class="form__group">
           <div class="form__input--group form__group--input form__effect">
            <input type="password" name="password" id="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[~!@#$%^&*()\-+=?\/<>|[\]{}_ :;\.,`]).{8,15}$" title="Must at least have 8 and no more than 15 characters containing a number, an uppercase and lowercase letter and use one of these special characters ~!@#$%^&*()-+=?/<>|[]{}_ :;.,`" class="form__item form__input-type arrow-togglable" value="<?php echo getPost('password'); ?>" autofocus required>
            <span class="form__group--password form__group--password-show">show</span>
            <span class="form__group--password form__group--password-hide">hide</span>
          </div>
          <div class="form__group--info">
            <a href="#" class="form__group--info-link" title="Your password" data-content="Must at least have 8 and no more than 15 characters containing a number, an uppercase and lowercase letter and use one of these special characters ~!@#$%^&*()-+=?/<>|[]{}_ :;.,`"><svg class="icon-smallest icon-primary">
              <use xlink:href="sprite/sprite.svg#icon-info"></use></svg></a>
              <div class="popover"></div>
           </div>
         </div>
            <label for="cpassword" class="text-muted form__effect">Confirm password:</label>
         <div class="form__group">
           <div class="form__input--group form__group--input form__effect">
            <input type="password" name="confirm_password" id="cpassword" class="form__item form__input-type arrow-togglable" value="<?php echo getPost('confirm_password'); ?>" required>
            <span class="form__group--password form__group--password-show">show</span>
            <span class="form__group--password form__group--password-hide">hide</span>
            </div >
            <div class="form__group--info">
              <a href="#" class="form__group--info-link" title="To confirm password" data-content="Must be the same as the password you've entered above"><svg class="icon-smallest icon-primary">
              <use xlink:href="sprite/sprite.svg#icon-info"></use></svg></a>
              <div class="popover"></div>
           </div>
         </div>
         <div class="flex__button form__effect">
             <button type="submit" name="change_password" id="change-password-submit" class="btn btn__primary flex__button-item">Save Changes</button>
             <a href="profile.php" class="btn btn__dark flex__button-item">Cancel</a>
         </div>
       </form>
     </div>
   </div>
 </section>

 <!-- header closing tags-->

<?php include("includes/close_tags.php");
