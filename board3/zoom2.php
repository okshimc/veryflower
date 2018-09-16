<?php
include("../inc/dbcon.php");
include("board_inc/board_function.php");

if(file_exists("$board_upload_dir/$img"))
{
	$size=GetImageSize("$board_upload_dir/$img");
	$width=$size[0];
	$height=$size[1];
}
else
{
	echo("<script>alert('이미지가 없습니다.');window.close();</script>");
}

?>
<html>
<head> 
<meta http-equiv="imagetoolbar" CONTENT="no"> 
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>이미지 사이즈 : <?=$width?> x <?=$height?></title> 
<script language="JavaScript1.2"> 
<!-- 
var ie=document.all; 
var nn6=document.getElementById&&!document.all; 
var isdrag=false; 
var x,y; 
var dobj; 
function movemouse(e) 
{ 
  if (isdrag) 
  { 
    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x; 
    dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y; 
    return false; 
  } 
} 
function selectmouse(e) 
{ 
  var fobj      = nn6 ? e.target : event.srcElement; 
  var topelement = nn6 ? "HTML" : "BODY"; 
  while (fobj.tagName != topelement && fobj.className != "dragme") 
  { 
    fobj = nn6 ? fobj.parentNode : fobj.parentElement; 
  } 
  if (fobj.className=="dragme") 
  { 
    isdrag = true; 
    dobj = fobj; 
    tx = parseInt(dobj.style.left+0); 
    ty = parseInt(dobj.style.top+0); 
    x = nn6 ? e.clientX : event.clientX; 
    y = nn6 ? e.clientY : event.clientY; 
    document.onmousemove=movemouse; 
    return false; 
  } 
} 
document.onmousedown=selectmouse; 
document.onmouseup=new Function("isdrag=false"); 
//--> 
</script> 
<style>.dragme{position:relative;}</style> 
</head> 

<body leftmargin="0" topmargin="0" bgcolor="#dddddd" style="cursor:arrow;"> 
<table width="100%" height="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center" valign="middle">
<img src="<?=$img?>" width="<?=$width?>" height="<?=$height?>" border="0" class="dragme" ondblclick="window.close();" style="cursor:move" title=" 이미지 사이즈 : <?=$width?> x <?=$height?> 

 이미지 사이즈가 화면보다 큽니다. 
 왼쪽 버튼을 클릭한 후 마우스를 움직여서 보세요. 

 더블 클릭하면 창이 닫힙니다. ">
 </td>
 </tr>
 </table>
 </body>
 </html>