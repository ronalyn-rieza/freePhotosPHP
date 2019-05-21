<?php
    include("includes/header.php");
?>
<title>freePhotos.io - Recover Password</title>
<?php
    include("includes/nav.php");
?>

<section id="" class="section">
  <div class="container">
    <div class="card card__medium">
      <h3 class="card__heading card__heading-medium">Recover Password</h3>
        <div class="warning-confirm__div">
          <?php
            display_message();
            recover_password();
          ?>
        </div>
      <form id="reset-password-form" method="post" role="form" autocomplete="off">
         <small class="text-muted">To begin the reset process, please enter your email below.</small>
        <input type="email" name="email" id="email" pattern="^(?!.*\.\.)[\w.\-#!$%&'*+\/=?^_`{}|~]{1,64}@[\w.\-]+\.[a-zA-Z]{2,3}$" title="example@mail.com" class="form__item mt-medium mb-large" placeholder="E-mail" value="<?php echo getPost('email'); ?>" autofocus required>
        <div class="flex__button form__effect">
            <button type="submit" name="recover-submit" id="recover-submit" class="btn btn__primary flex__button-item">Continue</button>
            <a href="index.php" class="btn btn__dark flex__button-item">Cancel</a>
        </div>
        <input type="hidden" class="" name="token" id="token" value="<?php echo token_generator(); ?>">
      </form>
  </div>
</div>
</section>

 <!-- header closing tags-->
<?php include("includes/close_tags.php");
