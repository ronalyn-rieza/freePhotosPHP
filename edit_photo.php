<?php
    include("includes/header.php");

?>
<title>freePhotos.io - Edit Photo</title>
<?php
    include("includes/logedin_nav.php");
?>

 <!-- edit photo -->
 <section id="" class="section">
   <div class="container">
     <div class="card card__medium">
       <h3 class="card__heading card__heading-medium">Change Profile Photo</h3>
         <div class="warning-confirm__div">
           <?php
               if(isset($_SESSION['user'])){

                    $user_id = abs((int)$_SESSION['user']);

                    edit_profile_pic($user_id);

                }else if(isset($_COOKIE['user'])){

                    $user_id = abs((int)$_COOKIE['user']);

                    edit_profile_pic($user_id);

                }
           ?>
       </div>
       <form id="change-profile-photo" method="post" class="mt-medium" enctype="multipart/form-data" runat="server" role="form">

            <input type="file" accept="image/*" name="profile_image" id="profile_image" class="form__item form__input-type arrow-togglable" onchange="loadFile(event);" required>
            <img id="preview" class="profile_delete_photo mt-large mb-medium">
         <div class="flex__button form__effect">
             <button type="submit" name="edit_photo" id="edit_photo" class="btn btn__primary flex__button-item">Upload Photo</button>
             <a href="profile.php" class="btn btn__dark flex__button-item">Cancel</a>
         </div>
       </form>
     </div>
   </div>
 </section>

 <!-- preview profile image -->
 <script type="text/javascript">
       var loadFile = function(event) {
            var reader = new FileReader();
               reader.onload = function(){
               var output = document.getElementById('preview');
               output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
      };
</script>

 <!-- header closing tags-->

<?php include("includes/close_tags.php");
