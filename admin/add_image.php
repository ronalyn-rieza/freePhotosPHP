<?php 
    include("admin_includes/admin_header.php");
?>
<title>freePhotos.io - Add Image</title>
<?php
    include("admin_includes/admin_nav.php"); 
?>

 <!-- add image  -->
<section id="add-image" class="">
    <div class="container">
        <div class="row">
            <div class="col-md-8 m-auto py-4">
                <div class="card mt-4">
                    <div class="card-header px-5 py-4">
                       <?php
                        
                        display_message();
                        
                           if(isset($_POST['publish_image'])){
        
    $image_category_title = clean($_POST['image_category_title']); 
    $fileName = clean($_FILES['image']['name']); // The file name
    $fileTmpLoc = clean($_FILES['image']['tmp_name']); // File in the PHP tmp folder
    $fileType = clean($_FILES['image']['type']); // The type of file it is
    $fileSize = clean($_FILES['image']['size']); // File size in bytes
    $kaboom = explode(".", $fileName); // Split file name into an array using the dot
    $fileExt = end($kaboom);
        
    $image_tags = clean($_POST['image_tags']);
 
    $error =[];
    
    if (!preg_match("/.(gif|jpg|png|jpeg)$/i", $fileName) ) {// making sure file is .gif|jpg|png|jpeg 
     
        $errors[] = "Your image was not .gif, .jpg, .jpeg, or .png - Please try again";
     
        unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
    }

    if($fileSize > 5242880) { // if file size is larger than 5 Megabytes
     
        $errors[] = "Your image was larger than 5 Megabytes in size - Please try again"; 
     
        unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
    }
    
    if(!empty($errors)){
           
        foreach ($errors as $error){
              
            echo validation_errors($error);
                
        }
            
    }else{

        //$moveResult = move_uploaded_file($fileTmpLoc, "../img/$fileName"); 
        
        $moveResult = move_uploaded_file($fileTmpLoc, "../img/org_".$fileName); 
        
        if ($moveResult != true) {
            
               echo "<p class='text-center py-2 mb-4 text-dark displyed-message-warning'>Image not uploaded - Please try again.</p>";
                
               unlink($fileTmpLoc);// Remove the uploaded file from the PHP temp folder
            
            }else{
            
                $thumbnail_name  = "thumbnail_".$fileName;
            
                $standard_name = "standard_".$fileName;
                
               //temporary file path
                $target_file = "../img/org_".$fileName; 
                //resized file path
                $thumbnail_file = "../img/".$thumbnail_name;
            
                $standard_file = "../img/".$standard_name;
            
                $thumbnail_w = 700;
                
                $thumbnail_h = 420;
                
                $standard_w = 1100;
            
                $standard_h = 660;
            
                resize_image($target_file,$standard_w,$standard_h,$fileExt,$standard_file);
            
                resize_image($target_file,$thumbnail_w,$thumbnail_h,$fileExt,$thumbnail_file);
           
                unlink($target_file);  //  clean up image storage
                //imagedestroy($img);        
                //imagedestroy($tci);
            
        
            $img_cat_title = escape($image_category_title);
            $img_standard_name = escape($standard_name);
            $img_thumbnail_name = escape($thumbnail_name);
            $img_type = escape($fileType);
            $img_size = escape($fileSize);
            $img_ext = escape($fileExt);
            $img_tags = escape($image_tags);
            
            $image_likes = 0; 
            
            $stmt = query_stmt("INSERT INTO images(image_cat_title, standard_name, thumbnail_name, image_type, image_post_date, image_tags, image_likes) VALUES(?, ?, ?, ?, now(), ?, ?)");
               
            mysqli_stmt_bind_param($stmt, "sssssi", $img_cat_title, $img_standard_name, $img_thumbnail_name, $img_type, $img_tags, $image_likes);
        
            mysqli_stmt_execute($stmt);
                
            confirm($stmt); 

            set_message("<p class='text-center py-2 mt-4 text-dark displyed-message-success'>New image has been uploaded </p>");

            redirect("images.php");
        
        }//move uploaded file success closing tag
     
    }//no error closing tag
        
}// if isset POST closing tag
                       ?>
                         
                            <h3>Add Image</h3>
                             
                    </div>
                    <div class="card-body my-3">
                    <form id="add-image" method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <select name="image_category_title" class="form-control form-control-input" required>
                                        <option value="">Select Category</option>
<?php
               
$query = "SELECT * FROM categories";
$get_categories_id = query($query);
confirm($get_categories_id);
                                        
while($row = mysqli_fetch_assoc($get_categories_id)){
$cat_id = $row['cat_id']; 
$cat_title = $row['cat_title'];
    
 echo "<option value='$cat_title'>$cat_title</option>";   
    
}
               
?>                
                
                                    </select>
                                </div>
            
                                <div class="form-group">
                                    <label for="post_image" class="text-muted">Choose Image</label>
                                    <input type="file" name="image" id="post_image" class="form-control form-control-input" onchange="readURL(this);" value="<?php echo getPost("post_image"); ?>" required>
                                    <img id="preview" src="#" alt="" width='auto' height='auto' class="img img-fluid my-4 add-img-preview">
                                </div>     

                                <div class="form-group">          
                                    <label for="post_tags" class="text-muted">Image Tags</label> 
                                    <textarea name="image_tags" class="form-control form-control-input" rows="7" value="<?php echo getPost("image_tags"); ?>" required></textarea>
                                </div> 
                    
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="form-control btn btn-outline-info mt-3" type="submit" name="publish_image" value="Publish Image">  
				                        </div>
				                        <div class="col-md-6">
				                            <a class="btn btn-outline-dark form-control mt-3" href="images.php">Cancel</a>
				                        </div>
				                    </div>
				                </div>    
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

   <!-- preview  image -->
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

                reader.onload = function (e) {
                    
                    $('#preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
        }
    }
</script>             
<?php 
    include("admin_includes/admin_close_tags.php");