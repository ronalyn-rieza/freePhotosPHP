<?php
//including header tags
include("includes/header.php");

    //show dynamic category title
    $query = "SELECT cat_title FROM categories";

    $select_all_categories_query = query($query);

    confirm($select_all_categories_query);

        while($row = mysqli_fetch_assoc($select_all_categories_query)){

        $cat_title = $row['cat_title'];

            if(isset($_GET['category']) && $_GET['category'] == $cat_title){

              echo "<title>freePhotos.io - $cat_title</title>";

            }
        }
//including nav bar tags
include("includes/logedin_nav.php");

?>
<!-- images grid -->
<section id="" class="section section--light">
    <div class="container">

     <?php
         display_message();
         query_mail();
      ?>

     <div class="images-grid" id="">

<?php
//checking if get category is set and show all the images in data base from this category
if(isset($_GET['category'])){

    $image_cat_title = clean($_GET['category']);

    if(isset($_GET['page'])){

        $page = abs((int)$_GET['page']);

    }else{

        $page = 1;

    }

    $shownimg_num = 12;

    if($page === "" || $page === 1){

        $page_1 = 0;

    }else{

        $page_1 = ($page * $shownimg_num) - $shownimg_num;

    }

//selecting all post from database and echo them on main content of the webpage
$query = "SELECT image_id, standard_name, thumbnail_name, image_likes FROM images WHERE image_cat_title = '".escape($image_cat_title)."' AND image_post_date != '' ORDER BY image_id DESC LIMIT $page_1, $shownimg_num";
$result = query($query);
confirm($result);

   if(mysqli_num_rows($result) < 1){

       echo "<h1>No Image Available here</h1>";

   }else{

        while($row = mysqli_fetch_assoc($result)){
            $image_id = $row['image_id'];
            $standard_name = $row['standard_name'];
            $thumbnail_name = $row['thumbnail_name'];
            $image_likes = $row['image_likes'];
 ?>


         <div class="images-grid__item reveal-item" id="">
            <div class='images-grid__item--imgs'>
                <a href="#" class="images-grid__item--imgs-link open-modal modal-link" data-id="<?php echo $image_id; ?>">
                    <picture>
                      <source srcset="img/<?php echo $standard_name; ?>" media="(min-width: 768px)">
                      <img data-srcset="img/<?php echo $thumbnail_name; ?>" alt="<?php echo $thumbnail_name; ?>" class="lazyload main-imgs">
                    </picture>
                </a>

                <div class="like__download">

                <?php
                   //show if the user like the image already
                    if(isset($_SESSION['user'])){

                        $user_id = abs((int)$_SESSION['user']);

                        image_like($user_id,$image_id,$image_likes);

                    }else if(isset($_COOKIE['user'])){

                        $user_id = abs((int)$_COOKIE['user']);

                        image_like($user_id,$image_id,$image_likes);

                    }
                    // download image link
                    echo "<a href='download.php?file=$image_id' class='like__download--download-link btn btn__small-primary'><svg class='icon-smallest icon-light'><use xlink:href='sprite/sprite.svg#icon-download'></use></svg> Download</a>";

                ?>
                </div>
                </div>
                <hr>
           </div>

<?php   } } //number or rows and while loop closing tags ?>

        </div><!--images row closing tag-->


<?php

//get how many images in database
 $image_count_query = "SELECT image_id FROM images WHERE image_cat_title = '".escape($image_cat_title)."' AND image_post_date != ''";
 $find_image_count = query($image_count_query);
 confirm($find_image_count);
 $image_count = mysqli_num_rows($find_image_count);

    if($image_count > $shownimg_num){

      echo "<div class='pagination'>"; // pagination row div
               echo "<ul class='pagination__item'>";

        $count = ceil($image_count / $shownimg_num);
        //prev page link
        if($page > 1 ){

            $j = $page - 1;

            echo "<li class='btn pagination__item-prev'><a class='' href='category.php?category=$image_cat_title&page=$j'>Prev</a></li>";

        }
        if($count > 1){
        //looping pagination pages
            for($i = 1; $i <= $count; $i++ ){

                if($i === $page){

                echo "<li class='btn pagination__item-page'>{$i} of {$count}</li>";

                }
            }

        }
        //next page link
        if($page < $count ){

            $j = $page + 1;

            echo "<li class='btn pagination__item-next'><a class='' href='category.php?category=$image_cat_title&page=$j'>Next</a></li>";

        }


                      echo "</ul>";
              echo "</div>"; //end of row pagination div

    }
?>


<?php

}else{// get category else statement


   redirect("home.php");

}// get category closing tag
?>
     </div><!-- container closing div -->
</section>

   <!-- footer - about and contact -->

  <?php include("includes/footer.php"); ?>
 <!-- =========================== -->


 <!--modals-->
 <div class="modal" id="">
   <div class="modal__content">

   </div>
 <div class="modal__close close">X</div>
 </div>

 <!-- header closing tags-->

<?php include("includes/close_tags.php");
