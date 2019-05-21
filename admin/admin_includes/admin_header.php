<?php include("../config/init.php");

//preventing non user to access the admin section
if(!isset($_SESSION['user']) && !isset($_COOKIE['user'])){
    
   redirect("../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="keywords" content="ronalyn rieza, commercial photography,
		product photography, food and drink photography,
		landscape,seascape,street photography, free photos, freephotos, .io">
	<meta name="description" content="Download Free Photos that can be used for personal and commercial purposes.">	
	<meta name="author" content="ronalyn rieza">
  