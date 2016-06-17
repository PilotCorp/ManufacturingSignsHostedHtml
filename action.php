<?php
  require_once('shared_functions.php');
  $action = $_GET['action'];

  switch (strtolower($action)) {
    case 'soft':
    case 'softreboot':
      exec('killall -q iceweasel');
      $url = get_bootSite();
      exec("(iceweasel $url --display=:0 --profile /home/pi/kioskProfile &) > /dev/null 2>&1");
      echo json_encode("done");
      break;
    case 'killvideo':
    case 'killvideos':
      exec('killall omxplayer omxplayer.bin videoplayer'); 
      echo json_encode("done");
      break;
    case 'startvideo':
    case 'startvideos':
      exec('(/home/pi/videoplayer &) > /dev/null');
      echo json_encode("done");
      break;
    default:
      echo json_encode("'$action' not recognized");
  }

?>

