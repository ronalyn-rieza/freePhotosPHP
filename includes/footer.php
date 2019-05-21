<!-- footer - about and contact -->
<footer id="" class="section section--primary footer">
    <div class="container">
        <div class="footer__content">
            <div class="footer__content--about">
              <h6 class="">About</h6>
              <p class="mt-medium">freePhotos.io provides high quality photos and completely free to use, for absolutely any purpose whatsoever. All photos are nicely tagged and categorized to help you browse and locate the images easily. All you have to do is to
                <?php

                    if(!isset($_SESSION['user']) && !isset($_COOKIE['user'])){

                            echo "<a  href='register.php' class='btn btn__dark'>Sign Up</a>";
                    }else{

                        echo "<a  href='#' class='btn btn__dark disabled'>Sign Up</a>";

                    }

                ?>
              and start browsing and downloading.</p>
            </div>
            <div class="footer__content--contact">
                <h6 class="mt-medium">Get In Touch</h6>
                 <form id="" method="post" role="form" autocomplete="off" role="form">
                         <label for="contact-name" class="">Name: </label>
                         <input id="contact-name" type="text" name="contact_name" pattern="^[^-\s][a-zA-Z ,\.'\-]{2,20}$" title="Must contain at least 2 and no more than 20 characters, no numbers and can only use . , ' - as special characters." class="form__item fl-cap mb-medium color-light form__input--fistLetter-cap arrow-togglable" value="<?php echo getPost('contact_name'); ?>" required>

                         <label for="contact-email" class="">E-mail: </label>
                         <input id="contact-email" type="email" name="contact_email" class="form__item mb-medium color-light arrow-togglable" pattern="^(?!.*\.\.)[\w.\-#!$%&'*+\/=?^_`{}|~]{1,64}@[\w.\-]+\.[a-zA-Z]{2,3}$" title="example@mail.com" value="<?php echo getPost('contact_email'); ?>" required>

                         <label for="contact-message" class="">Message: </label>
                         <textarea id="contact-message" name="contact_message" class="form__item mb-large color-light form__input--fistLetter-cap arrow-togglable" rows="7" required><?php echo getPost('contact_message'); ?></textarea>

                         <button name="contact_form_submit" type="submit" class="btn btn__light full-width">Submit</button>
                </form>
            </div>
        </div>
         <p class="footer__copyright">Built by <a href="#" class="">Ronalyn Rieza</a> ~ CopyRight 2018</p>
    </div>
</footer> <!-- =========================== -->
