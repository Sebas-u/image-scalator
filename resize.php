<?php
//Movemos el archivo temporal a la carpeta deseada para poder tratar la imagen, guardando la imagen en $img
$tmp_name =  $_FILES['fileToUpload']['tmp_name'];
$name = $_FILES['fileToUpload']['name'];
move_uploaded_file($tmp_name,"images/".$name);
$img = "images/".$name;

include_once "functions/image-scalator.php";

$new_width  = $_POST['width'];
$new_height = $_POST['height'];
resizeImg($img,$new_width,$new_height);

header("location:index.php");
