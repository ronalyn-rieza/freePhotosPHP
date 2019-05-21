<?php include("config/init.php");

//preventing non user to access the whole website
if(!isset($_SESSION['user']) && !isset($_COOKIE['user'])){

    redirect("index.php");
}

// show edit profile modal body

    if(isset($_GET['user_id_account'])){

    $user_id = abs((int)$_GET['user_id_account']);

    if($user_id == $_SESSION['user'] || $user_id == $_COOKIE['user']){

            echo "<div class='modal-body'>";

    $stmt = query_stmt("SELECT user_id, user_firstname, user_lastname, user_email FROM users WHERE user_id = ? AND active = 1 AND time_online != 0");

    confirm($stmt);

    if(isset($stmt)){

        mysqli_stmt_bind_param($stmt, "i", $user_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $user_id, $user_firstname, $user_lastname, $user_email);
    }

    while(mysqli_stmt_fetch($stmt)){

        $db_user_id = $user_id;
        $db_user_firstname = $user_firstname;
        $db_user_lastname = $user_lastname;
        $db_user_email = $user_email;

    }

?>

<div class="modal__form">
<div class="card modal__form--card">
  <h3 class="card__heading card__heading-medium">Edit profile</h3>
  <form id="edit-profile-form" method="post" action="profile.php" class="mt-medium" autocomplete="off">
    <label for="firstname" class="text-muted form__effect">Firstname:</label>
     <div class="form__group">
       <input name="profile_fname" type="text" id="firstname" pattern="^[^-\s][a-zA-Z ,\.'\-]{2,20}$" title="Must contain at least 2 and no more than 20 characters, no numbers and can only use . , ' - as special characters." class="form__item form__group--input form__effect form__input--fistLetter-cap" placeholder="<?php echo $db_user_firstname; ?>" autofocus required>
      <div class="form__group--info">
       <a href="#" class="form__group--info-link" title="Your Firstname" data-content="Must contain at least 2 and no more than 20 characters, no numbers and can only use . , ' - as special characters."><svg class="icon-smallest icon-primary">
         <use xlink:href="sprite/sprite.svg#icon-info"></use></svg></a>
         <div class="popover"></div>
     </div>
    </div>
       <label for="lastname" class="text-muted form__effect">Lastname:</label>
    <div class="form__group mb">
       <input name="profile_lname" type="text" id="lastname" pattern="^[^-\s][a-zA-Z ,\.'\-]{2,20}$" title="Must contain at least 2 and no more than 20 characters, no numbers and can only use . , ' - as special characters." class="form__item form__group--input form__effect form__input--fistLetter-cap" placeholder="<?php echo $db_user_lastname; ?>" required>
      <div class="form__group--info">
       <a href="#" class="form__group--info-link" title="Your Lastname" data-content="Must contain at least 2 and no more than 20 characters, no numbers and can only use . , ' - as special characters."><svg class="icon-smallest icon-primary">
         <use xlink:href="sprite/sprite.svg#icon-info"></use></svg></a>
         <div class="popover"></div>
      </div>
    </div>
       <label for="your-email" class="text-muted form__effect">E-mail:</label>
    <div class="form__group">
       <input name="profile_email" type="email" id="your-email" pattern="^(?!.*\.\.)[\w.\-#!$%&'*+\/=?^_`{}|~]{1,64}@[\w.\-]+\.[a-zA-Z]{2,3}$" title="example@mail.com" class="form__item form__group--input form__effect" placeholder="<?php echo $db_user_email; ?>" required>
      <div class="form__group--info">
       <a href="#" class="form__group--info-link" title="Your e-mail" data-content="example@mail.com"><svg class="icon-smallest icon-primary">
         <use xlink:href="sprite/sprite.svg#icon-info"></use></svg></a>
         <div class="popover"></div>
      </div>
    </div>
    <div class="flex__button form__effect mt-medium">
        <input type="submit" name="save_profile_changes" value="Save Changes" class="btn btn__primary flex__button-item submit">
        <a href="profile.php" class="btn btn__dark flex__button-item close">Cancel</a>
    </div>
  </form>
</div>
</div>

<?php
}
}//end of get user_id_account
//end of edit profile modal body

//show images modal body
    if(isset($_GET['dataId'])){
    $image_id = abs((int)$_GET['dataId']);

             echo "<div class='modal__images'>";

    $stmt = query_stmt("SELECT image_id, standard_name, thumbnail_name, image_likes FROM images WHERE image_id = ? AND image_post_date != ''");

    confirm($stmt);

    if(isset($stmt)){

        mysqli_stmt_bind_param($stmt, "i", $image_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $image_id, $standard_name, $thumbnail_name, $image_likes);
    }

    while(mysqli_stmt_fetch($stmt)){

        echo "<picture>";
            echo "<source srcset='img/$standard_name' media='(min-width: 768px)'>";
            echo "<img srcset='img/$thumbnail_name' alt='$thumbnail_name' class='main-imgs'>";
        echo "</picture>";

    }

        echo "<div class='modal__like-download'>";

                    //showing if the user already like the image
                    if(isset($_SESSION['user'])){

                        $user_id = abs((int)$_SESSION['user']);

                        image_like($user_id,$image_id,$image_likes);


                    }else if(isset($_COOKIE['user'])){

                        $user_id = abs((int)$_COOKIE['user']);

                        image_like($user_id,$image_id,$image_likes);

                    }
        //image modal download link
        echo "<a href='download.php?file=$image_id' class='like__download--download-link btn btn__small-primary'><svg class='icon-smallest icon-light'><use xlink:href='sprite/sprite.svg#icon-download'></use></svg> Download</a>";

    echo "</div>";
    echo "</div>";

 }//end of get dataId
// end of images modal body

//show delete profile photo modal body
    if(isset($_GET['userId'])){
    $user_id = abs((int)$_GET['userId']);

    if($user_id == $_SESSION['user'] || $user_id == $_COOKIE['user']){

            echo "<div class='card card__small confirm__request'>";
                echo "<h3 class='card__heading card__heading-small'>Are you sure you want to delete your Profile Photo?</h3>";
                  echo "<div class='card__body'>";


    $stmt = query_stmt("SELECT user_id, user_image FROM users WHERE user_id = ? AND active = 1 AND time_online != 0");

    confirm($stmt);

    if(isset($stmt)){

        mysqli_stmt_bind_param($stmt, "i", $user_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $user_id, $user_image);
    }


    while(mysqli_stmt_fetch($stmt)){

        echo "<img src='users-profile-photo/".$user_image."?".time()."' class='profile_delete_photo'>";

    }
              echo "</div>";
            echo "<div class='card__footer flex__button mt-medium'>";
                echo "<a href='profile.php' class='btn btn__dark flex__button-item' data-dismiss='modal'>No</a>";
                echo "<a href='profile.php?deletepimage=$user_id' class='btn btn__secondary flex__button-item'>Yes</a>";
            echo "</div>";
            echo "</div>";
  }
}//end of get userId
// end of delete profile photo modal body -->

// show delete account modal body
    if(isset($_GET['userIdAccount'])){
    $user_account_id = abs((int)$_GET['userIdAccount']);

    if($user_account_id == $_SESSION['user'] || $user_account_id == $_COOKIE['user']){

                echo "<div class='card card__small confirm__request'>";
                    echo "<h3 class='card__heading card__heading-small'>Are you sure you want to delete your Account?</h3>";

    $stmt = query_stmt("SELECT user_id FROM users WHERE user_id = ? AND active = 1 AND time_online != 0");

    confirm($stmt);

    if(isset($stmt)){

        mysqli_stmt_bind_param($stmt, "i", $user_account_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $user_id);
    }


    while(mysqli_stmt_fetch($stmt)){

        $user_account_id = $user_id;

    }

                echo "<div class='card__footer flex__button mt-medium'>";
                    echo "<a href='profile.php' class='btn btn__dark flex__button-item'>No</a>";
                    echo "<a href='profile.php?delete=$user_account_id' class='btn btn__secondary flex__button-item'>Yes</a>";
                echo "</div>";
                echo "</div>";
    }
}//end of get userIdAccount
//end of delete account modal body -->

// add image like number
if(isset($_GET['imageId'])){

    $image_id = abs((int)$_GET['imageId']);

    //saving user who likes the image in likes table
    if(isset($_SESSION['user'])){

        $user_id = abs((int)$_SESSION['user']);

        save_image_like($user_id,$image_id);

    }else if(isset($_COOKIE['user'])){

        $user_id = abs((int)$_COOKIE['user']);

        save_image_like($user_id,$image_id);
    }

    //query to to display image like
    $stmt3 = query_stmt("SELECT image_likes FROM images WHERE image_id = ?");

    confirm($stmt3);

    if(isset($stmt3)){

        mysqli_stmt_bind_param($stmt3, "i", $image_id);

        mysqli_stmt_execute($stmt3);

        mysqli_stmt_bind_result($stmt3, $image_likes);

        mysqli_stmt_fetch($stmt3);
    }

    echo "<span class='like__download--likes-link btn btn__small-dark disabled'>You <svg class='icon-smallest icon-light'><use xlink:href='sprite/sprite.svg#icon-heart-outlined'></use></svg> $image_likes</span>";
}

?>
<!-- end of add image like number
