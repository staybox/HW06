<?php
require '../vendor/autoload.php';
use Intervention\Image\ImageManager;

$manager = new ImageManager(array('driver' => 'gd'));
$image = $manager->make('rotate/why.jpg')->rotate(-45);
$image->save('rotate/why_rotated.jpg');