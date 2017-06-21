<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title></title>

  <link rel="stylesheet" href="css/main.css">
  <link rel="icon" href="images/favicon.png">
</head>

<body>
  <form action="resize.php" method="post" enctype="multipart/form-data">
    <label for="fileToUpload">Select image to upload:</label>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <label for="width">Select new width:</label>
    <input type="number" min="0" name="width" id="width">
    <label for="height">Select new height:</label>
    <input type="number" min="0" name="height" id="height">
    <label for="download">Download?</label>
    <input type="checkbox" name="checkbox" value="1">
    <input type="submit" value="Upload Image" name="submit">
    
  </form>
</body>

</html>


