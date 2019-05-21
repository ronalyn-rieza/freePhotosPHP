<?php 
    include("admin_includes/admin_header.php");
?>
<title>freePhotos.io - Users</title>
<?php
    include("admin_includes/admin_nav.php"); 
?>

 <!-- users  -->
 <section id="users" class="bg-light">
     <div class="container">
        <div class="row">
           <div class="col">
               <?php display_message(); ?>
           </div>
        </div>
        <div class="row pt-4 pb-5">
            <div class="col">
                <div class="table-responsive mt-3">                          
                    <table class="table table-striped table-hover">
                        <thead style="background-color:#3292a6; color:#fff;">
                               <tr>
                                   <th>Firstname</th>
                                   <th>Lastname</th>
                                   <th>Email</th>
                                   <th>Role</th>
                                   <th>Active</th>
                                   <th>Status</th>
                                   <th>Change to</th>
                                   <th>Change to</th>
                                   <th></th>
                               </tr>
                           </thead>
                           <tbody>
                               
                                  
<?php
                               
 //setting how many images to show on the table 
                            
 if(isset($_GET['page'])){
      
    $page = abs((int)$_GET['page']);  
      
  }else{
      
    $page = 1;  
      
  }
                               
 $shownimg_num = 8;

  if($page == "" || $page == 1){
      
     $page_1 = 0; 
      
  }else{
      
     $page_1 = ($page * $shownimg_num) - $shownimg_num; 
      
  }                                                          
                               
$query = "SELECT user_id, user_firstname, user_lastname, user_email, user_role, time_online, active FROM users ORDER BY user_id DESC LIMIT $page_1, $shownimg_num";
$select_users = query($query);
confirm($select_users);
                               
   if(mysqli_num_rows($select_users) < 1){
       
       echo "<h1 class='text-center m-auto py-5'>No user available here</h1>";
       
   }else{
                                 
        while($row = mysqli_fetch_assoc($select_users)){
            $user_id = $row['user_id']; 
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_role = $row['user_role'];
            $active = $row['active'];
            $online_offline = $row['time_online'];
            $time = time() - 60*60*24;
        
            echo "<tr>";
                echo "<td>{$user_firstname}</td>";
                echo "<td>{$user_lastname}</td>";
                echo "<td>{$user_email}</td>";
                echo "<td>{$user_role}</td>";
                echo "<td>{$active}</td>";
                
                if($online_offline > $time){
                    
                    echo "<td>Online</td>"; 
                    
                }else{
                    
                    echo "<td>Offline</td>";
                }
            
                echo "<td><a href='users.php?Admin={$user_id}'>Admin</a></td>";
                echo "<td><a href='users.php?Subscriber={$user_id}'>Subsciber</a></td>";
                echo "<td><a href='#delete-user' data-toggle='modal' data-id='{$user_id}' style='color: red;' class='delete-user'>Delete</a></td>";
            echo "</tr>";
        }//end of while loop
   }//end of if num of rows
?>                                
                                
                            </tbody>
                        </table> 
                    </div><!--end of table-responsive div -->
                      
                      <!-- pagination link -->
                        <ul class="pagination justify-content-center mt-admin-pagi">
<?php 
                            
 //get how many images in database   
 $user_count_query = "SELECT user_id FROM users";
 $find_user_count = query($user_count_query);
 confirm($find_user_count);
 $user_count = mysqli_num_rows($find_user_count);
                            
    if($user_count >= 1){
         
        $count = ceil($user_count/ $shownimg_num);
        
        // prev page link
        if($page > 1 ){

            $j = $page - 1;
            
            echo "<li class='page-item'><a class='page-link' href='users.php?page=$j'>Prev</a></li>";
            
        }
           
       if($count > 1){
        //looping pagination pages
        for($i = 1; $i <= $count; $i++ ){
             
                if($i == $page){ 
                
                    echo "<li class='page-item active-link'>{$i} of {$count}</li>";
            
                }
            }
        }
    
        //next page link
        if($page < $count ){

           $j = $page + 1;
        
           echo "<li class='page-item'><a class='page-link' href='users.php?page=$j'>Next</a></li>";

        }
        
    }// end of if user_count > = 1                                
?>  
                        </ul>  
                      <!--end of pagination -->
                       
                       
<?php
if(isset($_GET['Admin'])){
    
   $user_admin = abs((int)$_GET['Admin']);
    
    $admin = 'Admin';
    
    $stmt = query_stmt("UPDATE users SET user_role = ? WHERE user_id = ?");
               
    mysqli_stmt_bind_param($stmt, "si", $admin, $user_admin);
        
    mysqli_stmt_execute($stmt);
                
    confirm($stmt);
    
    //header("Location: users.php");
    
    redirect("users.php");
    
}
                
if(isset($_GET['Subscriber'])){
    
   $user_subscriber = abs((int)$_GET['Subscriber']);
    
   $subscriber = 'Subscriber'; 
    
    $stmt = query_stmt("UPDATE users SET user_role = ? WHERE user_id = ?");
               
    mysqli_stmt_bind_param($stmt, "si", $subscriber, $user_subscriber);
        
    mysqli_stmt_execute($stmt);
                
    confirm($stmt); 
    
    //header("Location: users.php");
    
    redirect("users.php");
}

if(isset($_GET['delete'])){
  
    $delete_user = abs((int)$_GET['delete']);
    
    //getting and deleting the profile pic 
    $get_user_old_img = query("SELECT user_image FROM users WHERE user_id = '".escape($delete_user)."'");

    confirm($get_user_old_img);

    $row = fetch_array($get_user_old_img);

    $target_path = '../users-profile-photo/' . $row['user_image'];

    unlink($target_path);
    
     $stmt = query_stmt("DELETE FROM users WHERE user_id = ? ");
               
    mysqli_stmt_bind_param($stmt, "i", $delete_user);
        
    mysqli_stmt_execute($stmt);
                
    confirm($stmt); 
    
    set_message("<p class='text-center py-2 mt-4 text-dark displyed-message-success'>User has been deleted</p>");
    
    //header("Location: users.php");
    
    redirect("users.php");
    
}

?>                                  
                </div><!--table col closing div -->
                
                <div class="col-md-6 mt-3"><!--add user div -->
				    <a class="btn btn-outline-info d-block" href="add_user.php"><i class="fa fa-angle-double-left"></i> Add User <i class="fa fa-angle-double-right"></i></a>
				</div>       
                <div class="col-md-6 mt-3"><!--back to dashboard div -->
				    <a class="btn btn-outline-dark d-block" href="dashboard.php"><i class="fa fa-angle-double-left"></i> Back to Dashboard <i class="fa fa-angle-double-right"></i></a>
				</div>
                        
            </div> <!--second closing row div -->
        </div><!-- container closing div -->
</section>

<!--delete user modal -->              
<div id="delete-user" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            
        </div>
    </div>
</div>      
<!-- body and html closing tags-->                
<?php 
    include("admin_includes/admin_close_tags.php");