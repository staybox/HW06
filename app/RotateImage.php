<?php
require '../vendor/autoload.php';
use Intervention\Image\ImageManager;

class RotateImage
{
    public function Rotate()
    {
        $manager = new ImageManager(array('driver' => 'gd'));
        $image = $manager->make('rotate/why.jpg')->rotate(-45);
        $image->save('rotate/why_rotated.jpg');
    }

}

$Rotate = new RotateImage();
$Rotate->Rotate();