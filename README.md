# image-scalator
Upload IMG, set new dimensions, get new img with same dimensions or at least same aspect ratio if the original is smaller 

resizeImg is found in /functions/image-scalator.php
/********************************************************************************
	resizeImg params:
		$original 	-> original img resource
		$new_width 	-> integer new width 
		$new_height -> integer new height 
		$ruta 		-> path where $original will be stored, $ruta must exists
	
	resizeImg($img, 500, 400, 'images');
******************************************************************************/

The original image will be stored in ruta
The resized in Ruta/New_widthxNew_height/
