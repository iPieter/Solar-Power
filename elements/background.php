<?php

//select random file
$files = glob('images/backgrounds/*');

$rand_image = $files[array_rand($files)];
echo "<img src='$rand_image'>";
?>