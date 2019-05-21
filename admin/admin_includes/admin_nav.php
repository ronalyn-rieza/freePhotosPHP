<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
<?php
   // preventing subscriber to access admin pages
    if(isset($_SESSION['user_role'])){

        if($_SESSION['user_role'] !== 'Admin'){

        redirect("../home.php");

        }

    }else if(isset($_COOKIE['role'])){

        if($_COOKIE['role'] !== 'Admin'){

            redirect("../home.php");

        }
    }
?>
   <nav id="navigator" class="navbar navbar-expand-lg navbar-light fixed-top py-3 navbartop">
        <div class="container">
           <h1 class="web-name">Download Free Photos .io</h1>
            <a href="../home.php" class="navbar-brand"><img src="../img/web-logo3.png" alt="freephotos.io logo " class="logo"></a>
            <button class="navbar-toggler ml-auto" data-toggle="collapse" data-target="#navBarNav"><span class="navbar-toggler-icon"></span></button>
               <div class="collapse navbar-collapse ml-3" id="navBarNav">
                  <hr>
                   <ul class="navbar-nav">

<?php
                $pageName = basename($_SERVER['PHP_SELF']);

                $dashboard_class = '';

                $dashboard = 'dashboard.php';

                $images_class = '';

                $images = 'images.php';

                $add_image = 'add_image.php';

                $cat_class = '';

                $category = 'categories.php';

                $users_class = '';

                $users = 'users.php';

                $add_user = 'add_user.php';


                if($pageName == $dashboard){

                   $dashboard_class = 'active';

                }else if($pageName == $images){

                    $images_class = 'active';

                }else if($pageName == $add_image){

                    $images_class = 'active';

                }else if($pageName == $category){

                    $cat_class = 'active';

                }else if($pageName == $users){

                    $users_class = 'active';

                }else if($pageName == $add_user){

                    $users_class = 'active';

                }

?>

                        <li class="nav-item <?php echo $dashboard_class; ?>">
                            <a href="dashboard.php" class="nav-link "><i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="nav-item dropdown <?php echo $images_class; ?>">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-picture-o"></i> Images</a>
                            <div class="dropdown-menu" >
                                <a href="images.php" class="dropdown-item"><i class="fa fa-eye"></i> View All Images</a>
                                <a href="add_image.php" class="dropdown-item"><i class="fa fa-plus-square"></i> Add Image</a>
                            </div>
                        </li>
                        <li class="nav-item <?php echo $cat_class; ?>">
                            <a href="categories.php" class="nav-link"><i class="fa fa-filter"></i> Categories</a>
                        </li>
                        <li class="nav-item dropdown <?php echo $users_class; ?>">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users"></i> Users</a>
                            <div class="dropdown-menu">
                                <a href="users.php" class="dropdown-item"><i class="fa fa-eye"></i> View All Users</a>
                                <a href="add_user.php" class="dropdown-item"><i class="fa fa-plus-square"></i> Add User</a>
                            </div>
                        </li>
                    </ul>
                    <hr>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="../profile.php" class="nav-link active"><i class="fa fa-user"></i>

<?php

if(isset($_COOKIE['user'])){

    $cookie_user = abs((int)$_COOKIE['user']);

    $sql = "SELECT user_firstname FROM users WHERE user_id = '".escape($cookie_user)."' AND active = 1";

    $result = query($sql);

    confirm($result);

        $row = fetch_array($result);

        $db_firstname =  $row['user_firstname'];

        echo $db_firstname;



}else if(isset($_SESSION['user'])){

    $session_user = abs((int)$_SESSION['user']);

    $sql = "SELECT user_firstname FROM users WHERE user_id = '".escape($session_user)."' AND active = 1";

    $result = query($sql);

    confirm($result);

        $row = fetch_array($result);

        $db_firstname =  $row['user_firstname'];

        echo $db_firstname;


}
?>                          </a>
                    </li>
                    <li class="nav-item"><a href="../logout.php" class="nav-link"><i class="fa fa-user-times" style="color:#dc3545;"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
