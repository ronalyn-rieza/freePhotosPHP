<?php
    include("includes/header.php");

?>
<title>freePhotos.io - Download free Photos for Personal and Commercial Use</title>
<?php
    include("includes/nav.php");

//checking if user cookie is set and redirect to home page if user is subcriber, to admin page if user is admin
if(isset($_COOKIE['user'])){

    $user_id = abs((int)$_COOKIE['user']);

    get_user_role($user_id);

}
//checking if user session is set and redirect to home page if user is subcriber, to admin page if user is admin
if(isset($_SESSION['user'])){

    $user_id = abs((int)$_SESSION['user']);

    get_user_role($user_id);
}
?>
 <!-- images grid -->
 <section id="" class="section section--light">
     <div class="container">

                  <?php
                        display_message();
                        activate_user();
                        query_mail();
                   ?>

      <div class="images-grid" id="">
<?php
//setting how many images to show on the table
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

//selecting all image from database and echo them on main content of the webpage
$query = "SELECT image_id, standard_name, thumbnail_name, image_likes FROM images WHERE image_post_date != '' ORDER BY image_id DESC LIMIT $page_1, $shownimg_num";
$result = query($query);
confirm($result);

   if(mysqli_num_rows($result) < 1){

       echo "<h1>No Image Available here</h1>";

   }else{

    while($row = mysqli_fetch_assoc($result)){
        $image_id = $row['image_id'];
        $image_standard_name = $row['standard_name'];
        $image_thumbnail_name = $row['thumbnail_name'];
        $image_likes = $row['image_likes'];

 ?>

               <div class='images-grid__item reveal-item'>
                  <div class="images-grid__item--imgs">
                <a href="#" class="images-grid__item--imgs-link open-modal index-img-modal-link" data-id="<?php echo $image_id; ?>">
                    <picture>
                      <source srcset="img/<?php echo $image_standard_name; ?>" media="(min-width: 768px)">
                      <img data-srcset="img/<?php echo $image_thumbnail_name; ?>" alt="<?php echo $image_thumbnail_name; ?>" class="lazyload main-imgs">
                    </picture>
                </a>

                <div class="like__download">
                   <?php
                     echo "<a href='login.php?loginorsignuptolike' class='like__download--likes-link btn btn__small-secondary'>$image_likes <svg class='icon-smallest icon-light'><use xlink:href='sprite/sprite.svg#icon-heart-outlined'></use></svg></a>";

                    // echo "<a href='download.php?file=$image_id' class='like__download--download-link btn btn__small-primary'><svg class='icon-smallest icon-light'><use xlink:href='sprite/sprite.svg#icon-download'></use></svg> Download</a>";
                     echo "<a href='login.php?loginorsignuptolike' class='like__download--download-link btn btn__small-primary'><svg class='icon-smallest icon-light'><use xlink:href='sprite/sprite.svg#icon-download'></use></svg> Download</a>";

                   ?>
                </div>
                </div>
                <hr>
            </div>

<?php }}//num of rows and while loop closing tags?>

         </div>

<?php
//get how many images in database
$image_count_query = "SELECT image_id FROM images WHERE image_post_date != ''";
$find_image_count = query($image_count_query);
confirm($find_image_count);
$image_count = mysqli_num_rows($find_image_count);


    if($image_count > $shownimg_num){

        echo "<div class='pagination'>"; // pagination row div
                echo "<ul class='pagination__item'>";


        $count = ceil($image_count/ $shownimg_num);
        //prev page link
        if($page > 1 ){

            $j = $page - 1;

            echo "<li class='btn pagination__item-prev'><a class='' href='index.php?page=$j'>Prev</a></li>";

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

           echo "<li class='btn pagination__item-next'><a class='' href='index.php?page=$j'>Next</a></li>";

        }

                echo "</ul>";
        echo "</div>"; //end of row pagination div
    }

?>
     </div>
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
