<?php
declare(strict_types=1);

namespace Application\Core;

/**
 * Class GdGraphicsLibrary
 * @package Application\Core
 */
class GdGraphicsLibrary
{
    private $image;
    private $type;
    private $width;
    private $height;

    /**
     * @param string $path
     */
    function setImage(string $path)
    {
        $data = getimagesize($path);

        $this->width = $data[0];
        $this->height = $data[1];
        $this->type = $data[2];

        switch($this->type){
            case IMAGETYPE_JPEG:
                $this->image = imagecreatefromjpeg($path);
                break;
            case IMAGETYPE_GIF:
                $this->image = imagecreatefromgif($path);
                break;
            case IMAGETYPE_PNG:
                $this->image = imagecreatefrompng($path);
                break;
        }
    }

    /**
     *
     */
    function deleteImage()
    {
        imagedestroy($this->image);
    }

    /**
     * @param $path
     * @param int $quality
     */
    function save($path, $quality = 100)
    {
        switch($this->type){
            case IMAGETYPE_GIF:
                imagegif($this->image, $path);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($this->image, $path, $quality);
                break;
            case IMAGETYPE_PNG:
                $pngquality = floor(($quality - 10) / 10);
                imagepng($this->image, $path, $pngquality);
                break;
        }
    }

    /**
     * @param $path
     * @param $type
     * @param int $quality
     */
    function saveByType($path, $type, $quality = 100)
    {
        switch($type){
            case '1':
                imagegif($this->image, $path);
                break;
            case '2':
                imagejpeg($this->image, $path, $quality);
                break;
            case '3':
                $pngquality = floor(($quality - 10) / 10);
                imagepng($this->image, $path, $pngquality);
                break;
        }
    }

    /**
     *
     */
    function show()
    {
        switch($this->type){
            case IMAGETYPE_JPEG:
                imagejpeg($this->image);
                break;
            case IMAGETYPE_GIF:
                imagegif($this->image);
                break;
            case IMAGETYPE_PNG:
                imagepng($this->image);
                break;
        }
    }

    /**
     * @param $value
     * @param $prop
     */
    function resize($value, $prop)
    {
        $prop_value = ($prop == 'width') ? $this->width : $this->height;
        $prop_versus = ($prop == 'width') ? $this->height : $this->width;

        $pcent = $value / $prop_value;
        $value_versus = $prop_versus * $pcent;

        $image = ($prop == 'width') ? imagecreatetruecolor($value, $value_versus)
            : imagecreatetruecolor($value_versus, $value);

        switch($prop){
            case 'width':
                imagecopyresampled(
                    $image,
                    $this->image,
                    0,
                    0,
                    0,
                    0,
                    $value,
                    $value_versus,
                    $this->width,
                    $this->height
                );
                break;
            case 'height':
                imagecopyresampled(
                    $image,
                    $this->image,
                    0,
                    0,
                    0,
                    0,
                    $value_versus,
                    $value,
                    $this->width,
                    $this->height
                );
                break;
        }

        $this->width = imagesx($image);
        $this->height = imagesy($image);
        $this->image = $image;
    }

    /**
     * @param $value
     */
    function thumbnail($value)
    {
        $prop_value = $this->width;
        $prop_versus = $this->width;

        $pcent = $value / $prop_value;
        $value_versus = $prop_versus * $pcent;

        $image = imagecreatetruecolor($value, $value_versus);
        imagecopyresampled(
            $image,
            $this->image,
            0,
            0,
            0,
            0,
            $value,
            $value_versus,
            $this->width,
            $this->height
        );

        $this->width = imagesx($image);
        $this->height = imagesy($image);
        $this->image = $image;
    }

    /**
     * @param $value
     */
    function thumbnailPlus($value)
    {
        if($this->width > $this->height){
            $this->resize($value-50, 'width');
        }else{
            $this->resize($value-50, 'height');
        }

        $image = imagecreatetruecolor($value, $value);
        $color = imagecolorallocatealpha($image, 255, 255, 255, 0);
        imagefill($image, 0, 0, $color);

        imagecopy(
            $image,
            $this->image,
            abs(($this->width - $value) / 2),
            abs(($this->height - $value) / 2),
            0,
            0,
            $this->width,
            $this->height
        );

        $this->image = $image;
    }

    /**
     * @param $cwidth
     * @param $cheight
     * @param string $pos
     */
    function crop($cwidth, $cheight, $pos = 'center')
    {
        if($cwidth > $cheight){
            $this->resize($cwidth, 'width');
        }else{
            $this->resize($cheight, 'height');
        }

        $image = imagecreatetruecolor($cwidth, $cheight);

        switch($pos){
            case 'center':
                imagecopyresampled(
                    $image,
                    $this->image,
                    0,
                    0,
                    abs(($this->width - $cwidth) / 2),
                    abs(($this->height - $cheight) / 2),
                    $cwidth,
                    $cheight,
                    $cwidth,
                    $cheight
                );

                break;
            case 'left':
                imagecopyresampled(
                    $image,
                    $this->image,
                    0,
                    0,
                    0,
                    abs(($this->height - $cheight) / 2),
                    $cwidth,
                    $cheight,
                    $cwidth,
                    $cheight
                );

                break;
            case 'right':
                imagecopyresampled(
                    $image,
                    $this->image,
                    0,
                    0,
                    $this->width - $cwidth,
                    abs(($this->height - $cheight) / 2),
                    $cwidth,
                    $cheight,
                    $cwidth,
                    $cheight
                );

                break;
            case 'top':
                imagecopyresampled(
                    $image,
                    $this->image,
                    0,
                    0,
                    abs(($this->width - $cwidth) / 2),
                    0,
                    $cwidth,
                    $cheight,
                    $cwidth,
                    $cheight
                );

                break;
            case 'bottom':
                imagecopyresampled(
                    $image,
                    $this->image,
                    0,
                    0,
                    abs(($this->width - $cwidth) / 2),
                    $this->height - $cheight,
                    $cwidth,
                    $cheight,
                    $cwidth,
                    $cheight
                );

                break;
            default:
                break;
        }

        $this->image = $image;
    }
}
