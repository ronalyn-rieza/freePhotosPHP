<form action="" method="post"   class="mb-5">
    <fieldset class="form-control">
        <legend>Update Category</legend>
            <div class="form-group">
                                
<?php 
if (isset($_GET['edit'])){
    
    $edit_category = abs((int)$_GET['edit']);
    
    //select categories  from database
    $query = "SELECT * FROM categories WHERE cat_id = '".escape($edit_category)."'";
    $edit_categories_id = query($query);
    confirm($edit_categories_id);
    
    //looping the categories and show it on input value
    while($row = mysqli_fetch_assoc($edit_categories_id)){
        $cat_id = $row['cat_id']; 
        $cat_title = $row['cat_title']; 
   
?>
                <input value="<?php if(isset($cat_title)){echo $cat_title;} ?>" class="form-control fl-cap form-control-input" name="cat_title" type="text" pattern='.{3,20}' title='Must contain at least 3 and no more than 20 characters.' id="cat-title" required>
                
<?php } }//end of get edit and while loop 
                
 if(isset($_POST['update'])){
     
    $post_update_title = clean($_POST['cat_title']);
    
     $stmt = query_stmt("UPDATE categories SET cat_title = ? WHERE cat_id = ?");
               
        mysqli_stmt_bind_param($stmt, "si", $post_update_title, $cat_id);
        
        mysqli_stmt_execute($stmt);
                
        confirm($stmt);  
     
    set_message("<p class='text-center py-2 mb-4 text-dark displyed-message-success'>Category has been updated</p>");
                
    redirect("categories.php"); 
      
  }//end of post update                                            
                                   
?>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 mt-4">
                        <input class="form-control btn btn-outline-info" name="update" type="submit" value="Update Category">
                    </div>
                    <div class="col-md-6 mt-4">
                        <a class="btn btn-outline-dark form-control" href="categories.php">Cancel</a>
                    </div>
                </div>
            </div>
    </fieldset>
</form> 