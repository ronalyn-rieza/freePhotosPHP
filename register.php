<?php
    include("includes/header.php");
?>
<title>freePhotos.io - Register</title>
<?php
    include("includes/nav.php");
?>

<section id="" class="section">
  <div class="container">
    <div class="card card__medium">
      <h3 class="card__heading card__heading-medium">Sign Up</h3>
        <div class="warning-confirm__div">
          <?php
               display_message();
               validate_user_registration();
          ?>
      </div>
      <form id="register-form" method="post" class="mt-medium" autocomplete="off">
        <label for="fname" class="text-muted form__effect">Firstname:</label>
         <div class="form__group">
           <input type="text" name="first_name" id="fname" pattern="^[^-\s][a-zA-Z ,\.'\-]{2,20}$" title="Must contain at least 2 and no more than 20 characters, no numbers and can only use . , ' - as special characters." class="form__item form__group--input form__effect form__input--fistLetter-cap arrow-togglable" value="<?php echo getPost('first_name'); ?>" autofocus required>
          <div class="form__group--info">
           <a href="#" class="form__group--info-link" title="Your Firstname" data-content="Must contain at least 2 and no more than 20 characters, no numbers and can only use . , ' - as special characters."><svg class="icon-smallest icon-primary">
             <use xlink:href="sprite/sprite.svg#icon-info"></use></svg></a>
             <div class="popover"></div>
         </div>
        </div>
           <label for="lname" class="text-muted form__effect">Lastname:</label>
        <div class="form__group mb">
           <input type="text" name="last_name" id="lname" pattern="^[^-\s][a-zA-Z ,\.'\-]{2,20}$" title="Must contain at least 2 and no more than 20 characters, no numbers and can only use . , ' - as special characters." class="form__item form__group--input form__effect form__input--fistLetter-cap arrow-togglable" value="<?php echo getPost('last_name'); ?>" required>
          <div class="form__group--info">
           <a href="#" class="form__group--info-link" title="Your Lastname" data-content="Must contain at least 2 and no more than 20 characters, no numbers and can only use . , ' - as special characters."><svg class="icon-smallest icon-primary">
             <use xlink:href="sprite/sprite.svg#icon-info"></use></svg></a>
             <div class="popover"></div>
          </div>
        </div>
           <label for="email" class="text-muted form__effect">E-mail:</label>
        <div class="form__group">
           <input type="email" name="email" id="email" pattern="^(?!.*\.\.)[\w.\-#!$%&'*+\/=?^_`{}|~]{1,64}@[\w.\-]+\.[a-zA-Z]{2,3}$" title="example@mail.com" class="form__item form__group--input form__effect arrow-togglable" value="<?php echo getPost('email'); ?>" required>
          <div class="form__group--info">
           <a href="#" class="form__group--info-link" title="Your e-mail" data-content="example@mail.com"><svg class="icon-smallest icon-primary">
             <use xlink:href="sprite/sprite.svg#icon-info"></use></svg></a>
             <div class="popover"></div>
          </div>
        </div>
           <label for="password" class="text-muted form__effect">Password:</label>
        <div class="form__group">
          <div class="form__input--group form__group--input form__effect">
           <input type="password" name="password" id="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[~!@#$%^&*()\-+=?\/<>|[\]{}_ :;\.,`]).{8,15}$" title="Must at least have 8 and no more than 15 characters containing a number, an uppercase and lowercase letter and use one of these special characters ~!@#$%^&*()-+=?/<>|[]{}_ :;.,`" class="form__item form__input-type arrow-togglable" value="<?php echo getPost('password'); ?>" required>
           <span class="form__group--password form__group--password-show">show</span>
           <span class="form__group--password form__group--password-hide">hide</span>
         </div>
         <div class="form__group--info">
           <a href="#" class="form__group--info-link" title="Your password" data-content="Must at least have 8 and no more than 15 characters containing a number, an uppercase and lowercase letter and use one of these special characters ~!@#$%^&*()-+=?/<>|[]{}_ :;.,`"><svg class="icon-smallest icon-primary">
             <use xlink:href="sprite/sprite.svg#icon-info"></use></svg></a>
             <div class="popover"></div>
          </div>
        </div>
           <label for="cpassword" class="text-muted form__effect">Confirm Password:</label>
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
            <button type="submit" name="register_submit" id="register-submit" class="btn btn__secondary flex__button-item">Sign Up</button>
            <a href="index.php" class="btn btn__dark flex__button-item">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>

 <!-- header closing tags-->

<?php include("includes/close_tags.php");
