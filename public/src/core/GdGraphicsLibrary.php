<?php
declare(strict_types=1);

namespace Application\Core;

/**
 * Class GdGraphicsLibrary
 * @package Application\Core
 * @author jjpeleato
 *
 * https://www.php.net/manual/en/book.image.php
 */
class GdGraphicsLibrary
{
    /**
     * @var resource $image
     */
    public $image;

    /**
     * @var string $type
     */
    public $type;

    /**
     * @var int $width
     */
    public $width;

    /**
     * @var int $height
     */
    public $height;

    /**
     * Set the image for the next actions.
     *
     * Get the size of an image:
     * https://www.php.net/manual/en/function.getimagesize.php
     *
     * Create a new JPEG image from file or URL:
     * https://www.php.net/manual/en/function.imagecreatefromjpeg.php
     *
     * Create a new PNG image from file or URL:
     * https://www.php.net/manual/en/function.imagecreatefrompng.php
     *
     * Create a new GIF image from file or URL:
     * https://www.php.net/manual/en/function.imagecreatefromgif.php
     *
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
     * Destroy an image:
     * https://www.php.net/manual/en/function.imagedestroy.php
     */
    function deleteImage()
    {
        imagedestroy($this->image);
    }

    /**
     * Save the image.
     *
     * Output GIF image to browser or file:
     * https://www.php.net/manual/en/function.imagegif.php
     *
     * Output JPEG image to browser or file:
     * https://www.php.net/manual/en/function.imagejpeg.php
     *
     * Output a PNG image to either the browser or a file:
     * https://www.php.net/manual/en/function.imagepng.php
     *
     * @param string $path
     * @param int $quality
     */
    function save(string $path, int $quality = 100)
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
     * Save by type.
     *
     * Output GIF image to browser or file:
     * https://www.php.net/manual/en/function.imagegif.php
     *
     * Output JPEG image to browser or file:
     * https://www.php.net/manual/en/function.imagejpeg.php
     *
     * Output a PNG image to either the browser or a file:
     * https://www.php.net/manual/en/function.imagepng.php
     *
     * @param string $path
     * @param int $type 1: GIF, 2: JPEG, 3: PNG
     * @param int $quality
     */
    function saveByType(string $path, int $type, int $quality = 100)
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
     * Show the image.
     *
     * Output GIF image to browser or file:
     * https://www.php.net/manual/en/function.imagegif.php
     *
     * Output JPEG image to browser or file:
     * https://www.php.net/manual/en/function.imagejpeg.php
     *
     * Output a PNG image to either the browser or a file:
     * https://www.php.net/manual/en/function.imagepng.php
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
     * Automatically resize the image.
     *
     * Create a new true color image:
     * https://www.php.net/manual/en/function.imagecreatetruecolor.php
     *
     * Copy and resize part of an image with resampling:
     * https://www.php.net/manual/en/function.imagecopyresampled.php
     *
     * Get image width:
     * https://www.php.net/manual/en/function.imagesx.php
     *
     * Get image height:
     * https://www.php.net/manual/en/function.imagesy.php
     *
     * @param int $value
     * @param string $prop width|height
     */
    function resize(int $value, string $prop)
    {
        $prop_value = ($prop === 'width') ? $this->width : $this->height;
        $prop_versus = ($prop === 'width') ? $this->height : $this->width;

        $pcent = $value / $prop_value;
        $value_versus = intval($prop_versus * $pcent);

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
     * Generate thumbnail. Resize the image in the process.
     * It is possible that image not scale good.
     *
     * Create a new true color image:
     * https://www.php.net/manual/en/function.imagecreatetruecolor.php
     *
     * Copy and resize part of an image with resampling:
     * https://www.php.net/manual/en/function.imagecopyresampled.php
     *
     * Get image width:
     * https://www.php.net/manual/en/function.imagesx.php
     *
     * Get image height:
     * https://www.php.net/manual/en/function.imagesy.php
     *
     * @param int $value
     */
    function thumbnail(int $value)
    {
        $prop_value = $this->width;
        $prop_versus = $this->width;

        $pcent = $value / $prop_value;
        $value_versus = intval($prop_versus * $pcent);

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
     * Generate thumbnail. Not resize the image in the process.
     *
     * Create a new true color image:
     * https://www.php.net/manual/en/function.imagecreatetruecolor.php
     *
     * Allocate a color for an image:
     * https://www.php.net/manual/en/function.imagecolorallocatealpha.php
     *
     * Flood fill:
     * https://www.php.net/manual/en/function.imagefill.php
     *
     * Copy part of an image:
     * https://www.php.net/manual/en/function.imagecopy.php
     *
     * @param int $value
     */
    function thumbnailPlus(int $value)
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
     * Crop the image.
     * Look the following information:
     *
     * Create a new true color image
     * https://www.php.net/manual/en/function.imagecreatetruecolor.php
     *
     * Copy and resize part of an image with resampling
     * https://www.php.net/manual/en/function.imagecopyresampled.php
     *
     * @param int $cwidth
     * @param int $cheight
     * @param string $pos
     */
    function crop(int $cwidth, int $cheight, string $pos = 'center')
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
