<form action="test.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<?php
	//Movemos el archivo temporal a la carpeta deseada para poder tratar la imagen
		$tmp_name =  $_FILES['fileToUpload']['tmp_name'];
		$name = $_FILES['fileToUpload']['name'];
		move_uploaded_file($tmp_name,"test_images/".$name);
		$img = "test_images/".$name;


	function resizeImg($original,$new_width,$new_height,$ruta='./test_images/'){
		list($old_width, $old_height,$type) = getimagesize($original);

		$ratio = $old_width/$old_height;
		$new_ratio = ($new_width/$new_height);

		$ruta .= $new_width.'x'.$new_height.'/';
	    if (!file_exists($ruta)) {
        	mkdir($ruta, 0777, true);
    	}
		$folder = $ruta.basename($original);
/***********************INFO****************************		
echo <<< XXX

<br>Actual data<br>
Nombre : $original<br>
Type: $type <br>
Ratio: $ratio <br>
Width: $old_width px<br>
Height: $old_height px<br>
<hr>
<br>New data<br>
Ratio: $new_ratio <br>
Width: $new_width px <br>
Height: $new_height px <br>
Ruta final: $folder <br>
XXX;
***********************FIN INFO****************************/
	

		switch ($type) {
			case 2:
				$image = imagecreatefromjpeg($original);
				break;
			case 3:
				$image = imagecreatefrompng($original);
				break;
			case 1:
				$image = imagecreatefromgif($original);
				break;
		}

		if($ratio < $new_ratio){
			/********************************************************************************************
			Si la imagen original es más angosta, 
				1) Si el ancho original es menor o igual que el nuevo, unicamente recortaremos el alto para respetar el nuevo ratio  
				2) Si el ancho original es mayor que el nuevo, escalaremos ancho y recortaremos el alto

				//////////																				
				/	     / 																					
				/	     / 																					
				/	     / 			/////////////////////////////////////////////					
				/	1500 / 			/											/		
				/	 x   /       =>	/					1400*400				/					
				/	2400 / 			/											/						
				/	     / 			/											/				
				/	     / 			/											/						
				//////////			/////////////////////////////////////////////						
			*********************************************************************************************/

			if($old_width<=$new_width){
				//CASO A
				/********************************************************
				Como la imagen es más angosta y el ancho es menor que la imagen final,
				recortaremos el alto para conseguir la proporción adecuada
				*********************************************************/
				//RECORTAR EL ALTO
				$height = $old_width/$new_ratio; 	//Obtenemos el nuevo ancho para respetar el aspecto
				$y_start = ($old_height-$height)/2;	//Empezando a recortar por la mitad de todo lo que sobra, así lo centramos

				$imagen_p = imagecreatetruecolor($old_width,$height);		
				if(imagecopyresampled($imagen_p, $image, 0, 0, 0, $y_start,$old_width, $height, $old_width, $height)){			
					imagejpeg($imagen_p,$folder);
				}else{
					echo "No se pudo escalar";
				}	
				
				
			}else{
				//CASO B
				/********************************************************
				Como la imagen, siendo más angosta, es más ancha que la deseada, 
				escalaremos al ancho y recortaremos el alto sobrante.
				*********************************************************/
				$image = imagescale ( $image , $new_width);	//Escalamos la imagen al ancho deseado
				$height = $new_width/$ratio;	//Calculamos el alto de la imagen escalada
				$y_start = ($height-$new_height)/2;	//Empezando a recortar por la mitad de todo lo que sobra, así lo centramos
				$imagen_p = imagecreatetruecolor($new_width, $new_height);	
				if(imagecopyresampled($imagen_p, $image, 0, 0, 0, $y_start, $new_width, $new_height, $new_width, $new_height)){
					imagejpeg($imagen_p,$folder);
				}else{
					echo "No se pudo escalar";
				}
				
				

			}

		}else if($ratio > $new_ratio){
			/********************************************************************************************
			Si la imagen original es más ancha, 
				1) Si el alto original es menor o igual que el nuevo, unicamente recortaremos el ancho para respetar el nuevo ratio  
				2) Si el alto original es mayor que el nuevo, escalaremos alto y recortaremos el ancho
																/////////////															
	 															/	  		/					
	 		/////////////////////////////////////////////		/	  		/					
	 		/											/		/	 1400 	/			
	 		/				1400*400					/		/	  x		/
	       	/											/	=>	/	 2400 	/			
	 		/											/		/	  		/				
	 		/											/		/	  		/		
	 		/											/		/	  		/				
			/////////////////////////////////////////////		/////////////				
			*********************************************************************************************/

			if($old_height<=$new_height){
				//CASO C
				//RECORTAR EL ANCHO
				$width = $old_height*$new_ratio; 	//Obtenemos el nuevo ancho para respetar el aspecto
				$x_start = ($old_width-$width)/2;	//Empezando a recortar por la mitad de todo lo que sobra, así lo centramos

				$imagen_p = imagecreatetruecolor($width, $old_height);		
				if(imagecopyresampled($imagen_p, $image, 0, 0, $x_start, 0, $width, $old_height, $width, $old_height)){						
					imagejpeg($imagen_p,$folder);
				}else{
					echo "No se pudo escalar";
				}
				
			}else{
				//CASO D
				$width = $new_height*$ratio;			//Calculamos el ancho para escalar a partir del alto  (alto*proporcion = ancho)
				$image = imagescale ( $image , $width);	//Escalamos la imagen al alto deseado
				$x_start = ($width-$new_width)/2;		//Empezando a recortar por la mitad de todo lo que sobra, así lo centramos
				$imagen_p = imagecreatetruecolor($new_width, $new_height);	
				if(imagecopyresampled($imagen_p, $image, 0, 0, $x_start, 0, $new_width, $new_height, $new_width, $new_height)){
					imagejpeg($imagen_p,$folder);
				}else{
					echo "No se pudo escalar";
				}
			}

			
		}else if($ratio==1){
			/**********************************************************************************************************************
					Si el ratio es el mismo, escalamos la imagen únicamente
				/////////////////////////////////////////////				/////////////////////////////////////////////
				/	  										/ 				/											/							
				/	  										/ 				/											/							
				/	  										/ 				/											/					
				/	  										/ 				/											/		
				/	  										/       =>		/											/					
				/	  										/ 				/											/						
				/	  										/ 				/											/				
				/	  										/ 				/											/						
				/////////////////////////////////////////////				/////////////////////////////////////////////						
			*************************************************************************************************************************/
			if($image = imagescale ( $image , $new_width  )){		
				//CASO E
				imagejpeg($image,$folder);
			}else{
				echo "No se pudo escalar";
			}
		}
	}
	resizeImg($img,1400,470);
	resizeImg($img,800,533);
	resizeImg($img,1800,700);
?>				