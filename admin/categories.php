<?php
    include("admin_includes/admin_header.php");
?>
<title>freePhotos.io - Categories</title>
<?php
    include("admin_includes/admin_nav.php");
?>
 <!-- categories  -->
<section id="categories" class="">
    <div class="container">
        <div class="row">
            <div class="col">

            </div>
        </div>
        <div class="row pb-5">
            <div class="col-md-6 mt-5 p-5 bg-light">
               <?php display_message(); ?>
                <table class="table table-sm table-striped table-hover table-cat">
                    <thead>
                        <tr>

                            <th class='p-3'>Category Title</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

<?php

$query = "SELECT * FROM categories";
$select_categories = query($query);
confirm($select_categories);

    while($row = mysqli_fetch_assoc($select_categories)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>";
            echo "<td class='p-3'>{$cat_title}</td>";
            echo "<td class='p-3'><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
            echo "<td class='p-3'><a href='#delete-cat' data-toggle='modal' data-id='{$cat_id}' style='color: red;' class='delete-cat'>Delete</a></td>";
        echo "</tr>";
    }
?>
<?php
    // delete category
    if(isset($_GET['delete'])){

        $get_delete_id = abs((int)$_GET['delete']);


        $stmt = query_stmt("DELETE FROM categories WHERE cat_id = ? ");

        mysqli_stmt_bind_param($stmt, "i", $get_delete_id);

        mysqli_stmt_execute($stmt);

        confirm($stmt);

        set_message("<p class='text-center py-2 mb-4 text-dark displyed-message-success'>Category has been deleted</p>");

        redirect("categories.php");
    }
?>
                    </tbody>
                </table>
            </div>

                    <div class="col-md-6 mt-5 p-5 bg-light">

<?php
// link to edit categories
   if(isset($_GET['edit'])){

       $cat_id = abs((int)$_GET['edit']);
       //show edit category from
       include "admin_includes/admin_edit_cat.php";
   }

// save new category
if(isset($_POST['save'])){

    $cat_title = clean($_POST['cat_title']);

    $category = escape($cat_title);

    $stmt = query_stmt("INSERT INTO categories(cat_title) VALUES(?)");

    mysqli_stmt_bind_param($stmt, "s", $category);

    mysqli_stmt_execute($stmt);

    confirm($stmt);

    //$result = query($sql);

    set_message("<p class='text-center py-2 mb-4 text-dark displyed-message-success'>New category has been added</p>");

    redirect("categories.php");
}

?>

                <form action="" method="post" role="form">
                    <fieldset class="form-control">
                        <legend>Add Category </legend>
                            <div class="form-group">
                                <input class="form-control fl-cap form-control-input" name="cat_title" type="text" id="cat-title" pattern='.{3,20}' title='Must contain at least 3 and no more than 20 characters.' placeholder="Category Title" required>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 mt-4">
				                        <input class="form-control btn btn-outline-info" name="save" type="submit" value="Add Category">
				                    </div>
				                     <div class="col-md-6 mt-4">
				                        <a class="btn btn-outline-dark form-control" href="dashboard.php">Cancel</a>
				                    </div>
				                </div>
				            </div>
                    </fieldset>
                </form>

            </div><!-- end of add and edit cat col div -->
        </div><!-- end of row div -->
    </div><!-- end of container div -->
</section>

<!-- delete cat modal -->
<div id="delete-cat" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">

        </div>
    </div>
</div>
<?php
    include("admin_includes/admin_close_tags.php");
