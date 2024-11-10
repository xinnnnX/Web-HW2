<?php
if (!isset($_SESSION)) {
    session_start();
} //檢查SESSION是否啟動
$_SESSION['check_word'] = ''; //設置存放檢查碼的SESSION

//設置定義為圖片
header("Content-type: image/PNG");

/*
      imgcode($nums,$width,$high)
      設置產生驗證碼圖示的參數
      $nums 生成驗證碼個數
      $width 圖片寬
      $high 圖片高
    */
imgcode(5, 200, 50);

//imgcode的function
function imgcode($nums, $width, $high)
{
    //去除了數字0和1 字母小寫I、X、O和L，為了避免辨識不清楚
    $str = "23456789abcdefghjkmnpqrstuvwyzABCDEFGHJKLMNPQRSTUVWZ";
    $code = '';  //儲存隨機產生的密碼
    for ($i = 0; $i < $nums; $i++) {
        $code .= $str[mt_rand(0, strlen($str) - 1)];
    }

    $_SESSION['Checkword'] = strtolower($code); // 請注意這裡！！！！！！
    $_SESSION['code'] = strtolower($code);

    //建立圖示，設置寬度及高度與顏色等等條件
    $image = imagecreate($width, $high);
    $black = imagecolorallocate($image, mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 200));
    $border_color = imagecolorallocate($image, 21, 106, 235);
    $background_color = imagecolorallocate($image, 235, 236, 237);

    //建立圖示背景
    imagefilledrectangle($image, 0, 0, $width, $high, $background_color);

    //建立圖示邊框
    imagerectangle($image, 0, 0, $width - 1, $high - 1, $border_color);

    //在圖示布上隨機產生大量躁點
    for ($i = 0; $i < 1000; $i++) {
        imagesetpixel($image, rand(0, $width), rand(0, $high), $black);
    }

    //設定驗證碼隨機位置
    $strx = rand(10, 20);
    $font = "fonts/NotoSans.ttf"; // 指定TrueType字體檔案路徑
    $font_size = 20; // 設定字體大小
    for ($i = 0; $i < $nums; $i++) {
        $strpos = rand(30, 40); // Y軸隨機位置
        imagettftext($image, $font_size, rand(-30, 30), $strx, $strpos, $black, $font, substr($code, $i, 1));
        $strx += rand(30, 50); // 字元之間的距離
    }

    imagepng($image);
    imagedestroy($image);
}
