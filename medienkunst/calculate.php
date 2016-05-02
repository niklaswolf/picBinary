<?php
$file = $_FILES['picture'];
$a = move_uploaded_file($file['tmp_name'], 'pictures/source.jpg');
//echo "Picture uploaded!";

$imageSize = getimagesize('pictures/source.jpg');
$width = $imageSize[0];
$height = $imageSize[1];

$img = imagecreatefromjpeg('pictures/source.jpg');

$rasterX = 60;
$rasterY = 60;
$xInterval = round($width/$rasterX);
$yInterval = round($height/$rasterY);

$h=0;
for ($w=0; $w<$rasterX; $w++){
	$colorArray = array();
	$x = $w*$xInterval;
	$y = $h*$yInterval;
	$xStop = $x + $xInterval;
	$yStop = $y + $yInterval;
	
	$avgRed = 0;
	$avgGreen = 0;
	$avgBlue = 0;
	$counter = 0;
	for($x; $x< $xStop; $x++){
		for ($y; $y< $yStop; $y++){
			$colors = imagecolorsforindex($img, imagecolorat($img, $x, $y));
			$avgRed += $colors['red'];
			$avgGreen += $colors['green'];
			$avgBlue += $colors['blue'];
			$counter++;
		}
	}
	$avgRed = round($avgRed/$counter);
	$avgGreen = round($avgGreen/$counter);
	$avgBlue = round($avgBlue/$counter);
	echo "<span style='color: rgb(".$avgRed.",".$avgGreen.",".$avgBlue."); width: ".$xInterval."px'>bla</span>";
	
	
	//go to the next row
	if($w==$rasterX-1){
		$h++;
		$w = 0;
		echo '<br>';
	}
	if($h==$rasterY-1){
		break;
	}
}

?>