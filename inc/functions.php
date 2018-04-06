<?php
/**
 *  isLogged()
 *  @return bool
 */
function isLogged()
{
    if(!empty($_SESSION['user'])) {
        if(!empty($_SESSION['user']['id']) && is_numeric($_SESSION['user']['id']) ) {
           if(!empty($_SESSION['user']['name']) && !empty($_SESSION['user']['grade']) && !empty($_SESSION['user']['ip'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
                if($ip == $_SESSION['user']['ip']) {
                  return true;
                }
           }
        }
    }
    return false;
}

function uploadDataPictures($id)
{
  $chemin = 'posters/' . $id . '.jpg';
  if (file_exists($chemin)) { ?>
    <img class="card-img-top" src="posters/<?php echo $id ?>.jpg" alt=""
    style="height: 320px; width: 100%; display: block;"> <?php
} else { ?>
    <img class="card-img-top" src="https://www.xl6.com/images/grande_image_inexistante.png" alt="" style="height: 320px; width: 100%; display: block;"><?php
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

