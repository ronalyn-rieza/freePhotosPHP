<?php
include("config/init.php");

   if(isset($_GET['dataId'])){
    $image_id = clean($_GET['dataId']);
    $image_id = escape($image_id);
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
            echo "<img srcset='img/$thumbnail_name' alt='$thumbnail_name' class=''>";
        echo "</picture>";

    }


            echo "<div class='modal__like-download'>";
                    echo "<a href='login.php?loginorsignuptolike' class='like__download--likes-link btn btn__small-secondary'>$image_likes <svg class='icon-smallest icon-light'><use xlink:href='sprite/sprite.svg#icon-heart-outlined'></use></svg></a>";
                    //image modal download link
                    //echo "<a href='download.php?file=$image_id' class='like__download--download-link btn btn__small-primary'><svg class='icon-smallest icon-light'><use xlink:href='sprite/sprite.svg#icon-download'></use></svg> Download</a>";
                    echo "<a href='login.php?loginorsignuptolike' class='like__download--download-link btn btn__small-primary'><svg class='icon-smallest icon-light'><use xlink:href='sprite/sprite.svg#icon-download'></use></svg> Download</a>";
            echo "</div>";
            echo "</div>";

 }

?>
