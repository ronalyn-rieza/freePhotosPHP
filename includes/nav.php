<?php
// Require https
//if ($_SERVER['HTTPS'] != "on") {
//   $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
//  redirect($url);
//}
?>

  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/4.1.8/lazysizes.min.js"></script>
</head>
<body>
  <header class="header">
    <nav id="" class="nav container">
      <div class="nav__secondary">
        <a href="index.php" class="nav--logo-link"><h1><span class="nav--logo-link-ver-text">free</span>Ph<svg class="icon-small icon-primary">
          <use xlink:href="sprite/sprite.svg#icon-picasa"></use>
        </svg>Tos<span class="nav--logo-link-dot">.</span><span class="nav--logo-link-io">io</span></h1></a>
        <div class="nav__secondary--content">
          <hr>
          <ul class="nav__secondary--content__link">
             <li class="">
               <a href="login.php" class="btn btn__primary mr-medium">Login</a>  <small class="text-muted"> or</small> <a href="register.php" class="btn btn__secondary ml-medium">Sign UP</a>
             </li>
          </ul>
        </div>
      </div>
      <div class="nav__menu-icon--show-small">
        <div class="nav__menu-icon--show-small-middle"></div>
      </div>
    </nav>
  </header>
