<?php
    include("includes/header.php");
?>
<title>freePhotos.io - Reset Password</title>
<?php
    include("includes/nav.php");
?>

 <!-- recover password -->
 <section id="" class="section">
   <div class="container">
     <div class="card card__medium">
       <h3 class="card__heading card__heading-medium">Reset Password</h3>
         <div class="warning-confirm__div">
           <?php
               validate_recover_password_code();
           ?>
       </div>
       <form id="reset-password-form" method="post" class="mt-medium" role="form" autocomplete="off">
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

         <button type="submit" name="reset-submit" id="reset-submit" class="btn btn__primary full-width mt-large mb-medium">Reset Password</button>

       </form>
     </div>
   </div>
 </section>

 <!-- header closing tags-->

<?php include("includes/close_tags.php");
