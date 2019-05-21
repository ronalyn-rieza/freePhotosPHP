<?php include("../config/init.php");

if(!isset($_SESSION['user']) && !isset($_COOKIE['user'])){
    
   redirect("../index.php");
}

//view image modal body -->
    if(isset($_GET['dataId'])){
        
        $image_id = abs((int)$_GET['dataId']);
        
?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="img-div-modal">
                    <a href="#" data-dismiss="modal">
                    
<?php 
    $sql = "SELECT image_id, standard_name FROM images WHERE image_id = '".escape($image_id)."'";
    $result = query($sql);
    confirm($result);
        
        while($row = mysqli_fetch_assoc($result)){
            $image_id = $row['image_id'];            
            $image_name = $row['standard_name'];
        
            echo "<img src='../img/$image_name' class='img-fluid'>";  
       }  
?>            
                    </a>
                </div>
            </div>
<?php }// end of get dataId 
//end of view image modal body -->

//show delete image modal body -->
    if(isset($_GET['delete_image'])){
        
        $image_delete_id = abs((int)$_GET['delete_image']);
        
?>
            <div class="modal-body">
                <h4 class="text-center mt-2">Are you sure you want to delete this Image?</h4>
                    
<?php
        
    $sql = "SELECT image_id, thumbnail_name FROM images WHERE image_id = '".escape($image_delete_id)."'";
        
    $result = query($sql);
        
    confirm($result);
        
        while($row = mysqli_fetch_assoc($result)){
            $image_id = $row['image_id'];            
            $image_name = $row['thumbnail_name'];
        
            echo "<img src='../img/$image_name' class='img-fluid admin-imgs-modal'>"; 
       }
?>
                <div style="text-align:center;">
                    <button class="btn btn-outline-dark mt-5 mr-2" data-dismiss="modal">No</button>
                    <a href='images.php?delete=<?php echo $image_id; ?>' class="btn btn-outline-danger mt-5 ml-2">Yes</a>
                </div>
                    
            </div>
<?php }//end of get userIdAccount 
// end of delete account modal body -->

// show delete cat modal body -->
    if(isset($_GET['delete_cat'])){
   
        $delete_cat_id = abs((int)$_GET['delete_cat']);
        
?>
           
            <div class="modal-body">
                <h4 class="text-center mt-2">Are you sure you want to delete 
<?php
        
    $sql = "SELECT * FROM categories WHERE cat_id = '".escape($delete_cat_id)."'";
        
    $result = query($sql);
    
    confirm($result);
        
        while($row = mysqli_fetch_assoc($result)){
            $cat_id = $row['cat_id'];            
            $cat_title = $row['cat_title'];
        
            echo $cat_title;
           
       }
?> category?</h4>
                    
                <div style="text-align:center;">
                    <button class="btn btn-outline-dark mt-3 mr-2" data-dismiss="modal">No</button>
                    <a href='categories.php?delete=<?php echo $cat_id; ?>' class="btn btn-outline-danger mt-3 ml-2">Yes</a>
                </div>
                    
            </div>
           
<?php }//end of get delete_cat 
// end of delete cat modal body -->

// show delete user modal body -->
    if(isset($_GET['delete_user'])){
        
        $delete_user_id = abs((int)$_GET['delete_user']);
        
?>
            
            <div class="modal-body">
                <h4 class="text-center mt-2">Are you sure you want to delete 
<?php
        
    $sql = "SELECT user_id, user_firstname, user_lastname FROM users WHERE user_id = '".escape($delete_user_id)."'";
        
    $result = query($sql);
        
    confirm($result);
        
        while($row = mysqli_fetch_assoc($result)){
            $user_id = $row['user_id'];            
            $user_name = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
        
            echo $user_name ." ". $user_lastname;
           
       }
?>?</h4>
                    
                <div style="text-align:center;">
                    <button class="btn btn-outline-dark mt-3 mr-2" data-dismiss="modal">No</button>
                    <a href='users.php?delete=<?php echo $user_id; ?>' class="btn btn-outline-danger mt-3 ml-2">Yes</a>
                </div>
                    
            </div>
           
<?php }//end of get delete_user 
//end of delete user modal body