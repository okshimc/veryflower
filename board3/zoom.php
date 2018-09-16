<?php
include("../inc/dbcon.php");
include("board_inc/board_function.php");
?>
<html>
<head>
<title>마우스를 움직이면 스크롤됩니다. 이미지를 클릭하면 창이 닫힙니다.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
</head>

<font style="height:0;">
</font>

<script language="javascript"> 

	var windowX, windowY;
	var bLargeImage = 0;
	var x,y,mx,my;

	function fitWindowSize()
	{
		window.resizeTo(200, 200);
		width = 200 - (document.body.clientWidth -  document.images[0].width) + 55;
		height = 200 - (document.body.clientHeight -  document.images[0].height) - 10;

		windowX = (window.screen.width-width)/2;
		windowY = (window.screen.height-height)/2;
		if(width>screen.width){
			width = screen.width;
			windowX = 0;
			bLargeImage = 1;
		}
		if(height>screen.height){
			height = screen.height;
			windowY = 0;
			bLargeImage = 1;
		}
		x = width/2;
		y = height/2;
		window.resizeTo(width, height);
		window.moveTo(windowX,windowY);
	}

	var posX = 0;  
	var posY = 0;  
	var posX2 = 0;  
	var posY2 = 0;
	var captureMode = false;  

	function MouseCheck(event,obj) {
	   captureMode = captureMode ? false : true;
	   posX = event.x;
	   posY = event.y;
	   obj.style.cursor = captureMode ? 'move' : 'pointer';
	}  
	function scrollPage(event) {  
		if(!captureMode) return;
		move = 1;
		posX2 = event.clientX;  
		posY2 = event.clientY; 
		pX = posX - posX2; 
		pY = posY - posY2; 
		window.scrollBy(pX,pY); 
		posX = event.clientX;  
		posY = event.clientY;  
	} 

	function move(event){
		if(bLargeImage)	window.scroll(event.clientX - wx,event.clientY -wy);
		return true;
	}
</script>

<body onLoad="fitWindowSize();MouseCheck(event,zoomimg);" style='margin:0'>
<img id="zoomimg" src="<?=$img?>"  border="0" onClick='window.close()' onmousemove="scrollPage(event)" style="cursor:hand">
</body>
</html>