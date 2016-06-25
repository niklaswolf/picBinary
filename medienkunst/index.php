<?php
?>
<html>

<style>
	#picture-wrapper {
		display: flex;
	}
	#live {
		cursor: pointer;
	}
	#live, #result {
		flex: 0 0 50%;
		position: relative;
	}
	#preview {
		/margin: auto;
	}
	#face-guide {
		position: absolute;
		width: 460px;
		height: 620px;
		margin: 50px 0 0 130px;
		top: 0;
		left: 0;
		z-index: 2;
		border: 4px solid;
		border-radius: 40%;
		text-align: center;
		line-height: 620px;
		font-size: 10em;
		font-family: sans-serif;
		color: rgba(255,255,255,0.5);
	}
</style>
<body>
	<div id="picture-wrapper">
		<div id="live">
			<div id="preview"></div>
			<div id="face-guide">Klick!</div>
		</div>
		<div id="result"></div>
	</div>
</body>

<script src="webcamjs/webcam.js"></script>
<script type="text/javascript">

	Webcam.set({width: 1280, height: 720, dest_width: 1280, dest_height: 720, crop_width: 720, crop_height: 720});
	Webcam.attach("#preview");
	
    function countdown (count){
		if(count==0){
			document.getElementById('face-guide').innerHTML = 'Klick!';
			Webcam.snap( function(data_uri) {
				Webcam.upload(data_uri, 'calculate.php', function (code, text){
					document.getElementById('result').innerHTML = text;
				});  
	        });
		}
		else {
			document.getElementById('face-guide').innerHTML = count;
			setTimeout(function(){
				countdown(count-1);
			}, 1000);
		}
    }

    document.getElementById('live').addEventListener('click', function(){
		countdown(3);
    });
</script>
</html>