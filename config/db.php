<?php

/*=== connecting to database =============*/
$con = mysqli_connect('localhost', 'root', '', 'ronal720_freephotos_db');
/*========================================*/

/*=== counting row result from database ======*/
function row_count($result){

    global $con;

   return mysqli_num_rows($result);

}
/*===========================================*/
function row_stmt_count($result){

    global $con;

    return mysqli_stmt_num_rows($result);

}
/*=== scaping string  from input form before saving to database ===*/
function escape($string) {

	global $con;

	return mysqli_real_escape_string($con, $string);

}
/*=================================================================*/

/*===== confirming the query result from db ========*/
function confirm($result) {

	global $con;

    if(!$result) {

		die();

	}
}
/*===================================================*/

/*========== making query from database====*/
function query($query) {

	global $con;

	$result =  mysqli_query($con, $query);

	return $result;

}
/*===================================================*/
function query_stmt($query) {

	global $con;

	$result =  mysqli_prepare($con, $query);

	return $result;

}

/*=== fetching array from database ==========*/
function fetch_array($result) {

	global $con;

	return mysqli_fetch_array($result);

}
/*===========================================*/
