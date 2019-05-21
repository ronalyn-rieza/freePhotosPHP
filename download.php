<?php include("config/init.php");

//preventing non user to access the whole website
if(!isset($_SESSION['user']) && !isset($_COOKIE['user'])){

    redirect("index.php");
}

if(isset($_GET["file"])){

    $file_id = abs((int)$_GET["file"]);

    $stmt = query_stmt("SELECT standard_name FROM images WHERE image_id = ? AND image_post_date != ''");

    confirm($stmt);

    if(isset($stmt)){

        mysqli_stmt_bind_param($stmt, "i", $file_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $standard_name);
    }

    while(mysqli_stmt_fetch($stmt)){

        $standard_filename = $standard_name;

    }

    $standard_filepath ="img/".$standard_filename;

    download_file($standard_filepath);

}else{

   redirect("index.php");

}//get file


function download_file( $fullPath ){

    if(ini_get('zlib.output_compression')){

        ini_set('zlib.output_compression', 'Off');

    }

    if( file_exists($fullPath) ){

        $fsize = filesize($fullPath);
        $path_parts = pathinfo($fullPath);
        $ext = strtolower($path_parts["extension"]);

        switch ($ext) {
            case "pdf": $ctype="application/pdf"; break;
            case "exe": $ctype="application/octet-stream"; break;
            case "zip": $ctype="application/zip"; break;
            case "doc": $ctype="application/msword"; break;
            case "xls": $ctype="application/vnd.ms-excel"; break;
            case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg":
            case "jpg": $ctype="image/jpg"; break;
            default: $ctype="application/octet-stream";
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header("Content-Type: $ctype");
        header("Content-Disposition: attachment; filename=\"".basename($fullPath)."\";" );
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".$fsize);
        ob_clean();
        flush();
        readfile( $fullPath );

    }else{

        die('File Not Found');
    }
}// end of download_file function
