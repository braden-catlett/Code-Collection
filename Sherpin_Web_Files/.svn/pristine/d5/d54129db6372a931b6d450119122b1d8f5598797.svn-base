<html>
<head><title>test image</title></head>
<body>

<?
//header ("Content-type: image/png");
$string = $_GET['txt'];
echo "<b>".$string."</b><br/>";
$hash = md5($string) ;
echo "<i>".$hash."</i><br/>";
$cache_filename = "cache/" . $hash . ".png";
echo "<b>".$cache_filename."</b><br/>";
if(($file = @fopen($cache_filename,'rb')))
{
    while(!feof($file))
        print(($buffer = fread($file,$send_buffer_size))) ;
    fclose($file) ;
    exit ;
}
$font   = 4;
$width  = imagefontwidth($font) * strlen($string);
$height = imagefontheight($font);

$im = @imagecreate ($width,$height);
$background_color = imagecolorallocate ($im, 255, 255, 255); //white background
$text_color = imagecolorallocate ($im, 0, 0,0);//black text
imagestring ($im, $font, 0, 0,  $string, $text_color);
imagepng ($im, $cache_filename);
//readfile ($cache_filename);
?>
</body>
</html>