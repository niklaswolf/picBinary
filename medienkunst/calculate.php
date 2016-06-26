<?php
const rasterSize = 15;

$file = $_FILES['webcam'];
$a = move_uploaded_file($file['tmp_name'], 'pictures/source.jpg');
//echo "Picture uploaded!";
$imageSize = getimagesize('pictures/source.jpg');
$width = $imageSize[0];
$height = $imageSize[1];
$widthRest = $width%rasterSize;
$heightRest = $height%rasterSize;

$img = imagecreatefromjpeg('pictures/source.jpg');
$img = imagecrop($img, ['x' => 0, 'y' => 0, 'width' =>  $width-$widthRest, 'height' => $height-$heightRest]);
imagefilter($img, IMG_FILTER_PIXELATE, rasterSize);
imagefilter($img, IMG_FILTER_GRAYSCALE);

for ($w=0; $w<$width-$widthRest; $w+=rasterSize){
	for ($h=0; $h<$height-$heightRest; $h+=rasterSize){
		$colors = imagecolorsforindex($img, imagecolorat($img, $w, $h));
		$grayValue = $colors['red'];
		if ($grayValue <= 127){
			// paint black
			imagefilledrectangle($img, $w, $h, $w+rasterSize-1, $h+rasterSize-1, imagecolorresolve($img, 0, 0, 0));
			imagestring($img, 4, $w+4, $h+1, '0', imagecolorresolve($img, 255, 255, 255));
		}
		else {
			//paint white
			imagefilledrectangle($img, $w, $h, $w+rasterSize-1, $h+rasterSize-1, imagecolorresolve($img, 255, 255, 255));
			imagestring($img, 4, $w+4, $h+1, '1', imagecolorresolve($img, 0, 0, 0));
		}
	}
}

imagejpeg($img, 'pictures/modified.jpg');

?>
<img src="pictures/modified.jpg?time=<?=time()?>">

