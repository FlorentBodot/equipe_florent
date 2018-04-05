<?php

function uploadDataPictures( $id)
{
  $chemin = 'posters/' . $id . '.jpg';
  if (file_exists($chemin)) { ?>
    <img class="card-img-top" src="posters/<?php echo $id ?>.jpg" alt=""> <?php
} else { ?>
    <img class="card-img-top" src="https://www.xl6.com/images/grande_image_inexistante.png" alt="" style="height: 225px; width: 100%; display: block;"><?php
  }
}

function debug($array)
{
    echo'<pre>';
    print_r($array);
    echo'</pre>';
}

function failleXss($a) {
  return trim(strip_tags($a));
}