<?php include("config/init.php");

    if(isset($_SESSION['user'])){

        $session_id = abs((int)$_SESSION['user']);

        $online_sql = "UPDATE users SET time_online = 0 WHERE user_id ='".  escape($session_id)."' AND code_one != ''";

        $user_online = query($online_sql);

        confirm($user_online);


    }else if(isset($_COOKIE['user'])){

        $cookie_id = abs((int)$_COOKIE['user']);

        $online_sql = "UPDATE users SET time_online = 0 WHERE user_id ='".  escape($cookie_id)."' AND code_one != ''";

        $user_online = query($online_sql);

        confirm($user_online);

    }


	if(isset($_COOKIE['user'])) {

		unset($_COOKIE['user']);

		setcookie('user', '', time()-60*60*24, '/', '', FALSE, FALSE);

	}

    if(isset($_COOKIE['role'])) {

		unset($_COOKIE['role']);

		setcookie('role', '', time()-60*60*24, '/', '', FALSE, FALSE);

	}

    if(isset($_COOKIE[session_name()])){
      session_destroy();
      $_SESSION = array();
      setcookie(session_name(), '', time()-3600, '/', '', FALSE, FALSE);
    }

redirect("index.php");
