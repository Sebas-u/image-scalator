<?php
if(isset($_POST)){
  include_once "functions/image-scalator.php";
  $ruta = "test_images/";
  //Movemos el archivo temporal a la carpeta deseada para poder tratar la imagen, guardando la imagen en $img
  $tmp_name =  $_FILES['fileToUpload']['tmp_name'];
  $name = $_FILES['fileToUpload']['name'];
  move_uploaded_file($tmp_name,$ruta.$name);
  $img = $ruta.$name;

  $new_width  = $_POST['width'];
  $new_height = $_POST['height'];
  $download = isset($_POST['download'])?1:0;
  resizeImg($img,$new_width,$new_height,$ruta,$download);
}
header("location:index.php");
