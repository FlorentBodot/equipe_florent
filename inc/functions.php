<?php

function uploadDataPictures($filename, $value, $key)
{
  if (file_exists($filename)) { ?>
    <img class="card-img-top" src="posters/<?php echo $value['$key'] ?>.jpg" alt=""> <?php
} else { ?>
    <img class="card-img-top" src="https://cdn.discordapp.com/attachments/425680443828862988/431060419109715970/images.jpg" alt="" style="height: 225px; width: 100%; display: block;"><?php
  }
}
