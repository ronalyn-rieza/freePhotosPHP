<?php
    include("includes/header.php");
?>
<title>freePhotos.io - Login</title>
<?php
    include("includes/nav.php");
?>

 <!-- register new user form -->
<section id="login" class="section">
    <div class="container">
        <div class="card card__medium">
            <h3 class="card__heading card__heading-medium">Login</h3>
                <div class="warning-confirm__div">
                       <?php
                           if(isset($_GET['loginorsignuptolike'])){

                                $logintolike = clean($_GET['loginorsignuptolike']);

                                $logintolike = escape($logintolike);

                                set_message("<p class='bg-primary message message-small'>To Like or Download an image please Login or <a href='register.php'>Sign Up</a></p>");
                            }

                            display_message();

                            validate_user_login();
                        ?>
                </div>
            <form id="login-form" method="post" autocomplete="off" role="form">
                <input type="email" name="login_email" pattern="^(?!.*\.\.)[\w.\-#!$%&'*+\/=?^_`{}|~]{1,64}@[\w.\-]+\.[a-zA-Z]{2,3}$" title="example@mail.com" class="form__item mt-large mb-xlarge arrow-togglable first-input" placeholder="E-mail" value="<?php echo getPost('login_email'); ?>" autofocus required>

                <div class="form__input--group">
                  <input type="password" name="login_password" class="form__item form__input-type arrow-togglable" placeholder="Password" value="<?php echo getPost('login_password'); ?>" required>
                  <span class="form__input--group-password form__group--password-show">show</span>
                  <span class="form__input--group-password form__group--password-hide">hide</span>
                </div>

                <small class="form__forgot-pass"><a href="recover_password.php">Forgot Your Password?</a></small>
                <label class="form__remember"><input type="checkbox" name="remember" value="value"> Remember Me</label>
                <div class="flex__button">
                    <button type="submit" name="login_submit" class="btn btn__primary flex__button-item">Login</button>
                    <a href="index.php" class="btn btn__dark flex__button-item">Cancel</a>
                </div>
              </form>
          </div>
      </div>
 </section>

 <!-- header closing tags-->

<?php include("includes/close_tags.php");
