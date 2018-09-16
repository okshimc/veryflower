<?php

/*
썸네일 이미지 생성 클래스
*/


class thumbImage {

    var $real_path = '.';
    
    var $target_path = '.';

    var $add_name = 'thumb_';

    var $image_quality = 75;

    function imageResize($realImage, $target_ext, $width, $height) {

        static $extName;
        static $src;
        static $thumb;

        $extName = strtolower( substr( $realImage, -3 ) );

        switch($extName) {
            case 'peg' : 
            case 'jpg' : 
                $src = @ImageCreateFromJPEG($this->real_path . '/' . $realImage) or die('Cannot Open File!');
                break;
            case 'gif' :
                $src = @ImageCreateFromGIF($this->real_path . '/' . $realImage) or die('Cannot Open File!');
                break;
            case 'png' :
                $src = @ImageCreateFromPNG($this->real_path . '/' . $realImage) or die('Cannot Open File!');
                break;
            default :
                echo '이 파일은 변환할 수 없습니다.';
                exit;
        }

        $thumb = ImageCreateTrueColor($width, $height);
        ImageCopyResampled($thumb, $src, 0,0,0,0, $width, $height, ImageSX($src), ImageSY($src) );    

        $realImage = substr($realImage, 0, -3) . $target_ext;
        
        switch($target_ext) {
            case 'jpeg' : 
            case 'jpg' : 
                @ImageJPEG($thumb, $this->target_path . '/' . $this->add_name . $realImage, $this->image_quality) or die('Writing Error : Check - Directory and Filename.');
                break;
            case 'gif' :
                @ImageGIF($thumb, $this->target_path . '/' . $this->add_name . $realImage, $this->image_quality) or die('Writing Error : Check - Directory and Filename.');
                break;
            case 'png' :
                @ImagePNG($thumb, $this->target_path . '/' . $this->add_name . $realImage, $this->image_quality) or die('Writing Error : Check - Directory and Filename.');
                break;
            default :
                echo '이 확장자는 지원되는 확장자가 아닙니다.';
                exit;
        }

        ImageDestroy($src); 
        ImageDestroy($thumb); 
    }
}

# End Class.

/********* 사용법 *********
$obj = new thumbImage;
$obj->real_path = './img';        # 저장된 이미지가 있는곳.
$obj->target_path = './thumb';    # 썸네일 이미지가 저장될 곳.
$obj->add_name = 'test_';    # 없어도 됨. 기본값 thumb
$obj->image_quality = 80;    # 없어도 됨. 기본값 75 (75% 가 가장 압축대 화질이 괸찮아서...)
# imageResize(파일명, 변환될 확장자, 가로사이즈, 세로사이즈)
$obj->imageResize('test.jpg', 'jpg', 50, 50);    # sample.jpg를 200*150 size의 png로 저장
*/

?>