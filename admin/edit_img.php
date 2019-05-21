<?php 
    include("admin_includes/admin_header.php");
?>
<title>freePhotos.io - Edit Image</title>
<?php
    include("admin_includes/admin_nav.php"); 
?>
 <!-- edit image  -->
 <section id="edit-image" class="">
     <div class="container">
        <div class="row">
            <div class="col-md-8 m-auto py-4">
                <div class="card mt-4">
                    <div class="card-header px-5 py-4">
                       <?php
                        
                           if(isset($_GET['img_id'])){

    $get_edit_image = abs((int)$_GET['img_id']);

    $query = "SELECT thumbnail_name, image_tags, image_cat_title  FROM images WHERE image_id = '".escape($get_edit_image)."'";
    $result = query($query);
    
    confirm($result);
                                 
    while($row = fetch_array($result)){
        
        $image_name = $row['thumbnail_name'];
        $image_tags = $row['image_tags'];
        $image_cat_title = $row['image_cat_title'];

if(isset($_POST['edit_image'])){
    
    $image_cat_title = clean($_POST['image_category_title']);
    $image_tags = clean($_POST['image_tags']);
    
    $img_cat_title = escape($image_cat_title);
    $img_tags = escape($image_tags);
    
    //update image
    
    $stmt = query_stmt("UPDATE images SET image_cat_title = ?, image_tags = ? WHERE image_id = {$get_edit_image}");
               
    mysqli_stmt_bind_param($stmt, "ss", $img_cat_title, $img_tags);
        
    mysqli_stmt_execute($stmt);
                
    confirm($stmt);  
    
    set_message("<p class='text-center py-2 mt-4 text-dark displyed-message-success'>Image has been updated</p>");

    redirect("images.php");
    
}
                       ?>
                         
                            <h3>Edit Image</h3>
                             
                    </div>
                    <div class="card-body my-3">      
                <form id="edit-image" method="post" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="img-cat-title" class="text-muted">Image Category</label> 
                                <select name="image_category_title" id="img-cat-title" class="form-control" required>
                                    <option value="<?php echo $image_cat_title; ?>"><?php echo $image_cat_title; ?></option>
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
            
                            <div class="form-group edit-img">
                                <img width='80%' height='auto' class="d-block img img-fluid my-2 mx-auto" src='../img/<?php echo $image_name; ?>' alt=''>
                            </div>      

                            <div class="form-group">          
                                <label for="post_tags" class="text-muted">Image Tags</label> 
                                <textarea name="image_tags" class="form-control" rows="3" value="<?php echo $image_tags; ?>" required><?php echo $image_tags; ?></textarea>
                            </div> 
<?php  }}  //end of get img_id and while loop
?>                    
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control btn btn-outline-info mt-3" type="submit" name="edit_image" value="Edit Image">
				                    </div>
				                    <div class="col-md-6">
				                        <a class="btn btn-outline-dark form-control mt-3" href="images.php">Cancel</a>
				                    </div>
				                </div>
                    </div>    
                </form>
                    </div>
                </div>
            </div><!-- end of col div--> 
         </div><!-- end of row div--> 
     </div><!-- end of container div-->
</section>
            
<!-- body and html closing tags-->                
<?php 
    include("admin_includes/admin_close_tags.php");