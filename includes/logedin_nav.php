<link rel="stylesheet" href="css/style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/4.1.8/lazysizes.min.js"></script>
</head>
<body>

<?php
//preventing non user to access the whole website
if(!isset($_SESSION['user']) && !isset($_COOKIE['user'])){

    redirect("index.php");
}
?>

<header class="header">
  <nav id="" class="nav container">
    <div class="nav__primary">
      <a href="home.php" class="nav--logo-link"><h1><span class="nav--logo-link-ver-text">free</span>Ph<svg class="icon-small icon-primary">
        <use xlink:href="sprite/sprite.svg#icon-picasa"></use>
      </svg>Tos<span class="nav--logo-link-dot">.</span><span class="nav--logo-link-io">io</span></h1></a>
      <div class="nav__primary--content">
        <hr>

<?php
  //showing search bar to subscribers
  if(isset($_SESSION['user_role'])){

      $user_role = clean($_SESSION['user_role']);

      get_user_role_search_bar($user_role);

  }else if(isset($_COOKIE['role'])){

      $user_role = clean($_COOKIE['role']);

      get_user_role_search_bar($user_role);
  }

  // displying dynamic nav categories
  $query = "SELECT * FROM categories";

  $select_all_categories_query = query($query);

  confirm($select_all_categories_query);

     while($row = mysqli_fetch_assoc($select_all_categories_query)){

     $cat_title = $row['cat_title'];
     $cat_id = $row['cat_id'];

     $category_class = '';

         if(isset($_GET['category']) && $_GET['category'] == $cat_title){

            $category_class = 'active';

         }

         echo "<a href='category.php?category=$cat_title' class='$category_class nav__primary--content__link'>{$cat_title}</a>";

     }

   //showing dashboard link for admin to access
   if(isset($_SESSION['user_role'])){

      $session_user_role = clean($_SESSION['user_role']);

       $session_role = escape($session_user_role);

       if($session_role === 'Admin'){

           echo "<a href='admin/dashboard.php' class='nav__primary--content__link'>Dashboard</a>";
       }

   }else if(isset($_COOKIE['role'])){

       $cookie_user_role = clean($_COOKIE['role']);

       $cookie_role = escape($cookie_user_role);

       if($cookie_role === 'Admin'){

           echo "<a href='admin/dashboard.php' class='nav__primary--content__link'>Dashboard</a>";

       }
   }
?>
        <hr>
        <a href="profile.php" class="nav__primary--content__link-profile">
          <svg class="icon-small icon-primary">
            <use xlink:href="sprite/sprite.svg#icon-user"></use>
          </svg>
<?php

if(isset($_COOKIE['user'])){

    //displying user name
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

?>      </a>

        <a href="logout.php" class="nav__primary--content__link-logout">
          <svg class="icon-small icon-secondary">
            <use xlink:href="sprite/sprite.svg#icon-remove-user"></use>
          </svg> Logout
         </a>
      </div>
    </div>
    <div class="nav__menu-icon--show-medium">
      <div class="nav__menu-icon--show-medium-middle"></div>
    </div>
  </nav>
</header>
