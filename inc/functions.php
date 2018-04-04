<?php

function uploadDataPictures( $id)
{
  $chemin = 'posters/' . $id . '.jpg';
  if (file_exists($chemin)) { ?>
    <img class="card-img-top" src="posters/<?php echo $id ?>.jpg" alt=""> <?php
} else { ?>
    <img class="card-img-top" src="https://cdn.discordapp.com/attachments/425680443828862988/431060419109715970/images.jpg" alt="" style="height: 225px; width: 100%; display: block;"><?php
  }
}

function debug($array)
{
    echo'<pre>';
    print_r($array);
    echo'</pre>';
}

