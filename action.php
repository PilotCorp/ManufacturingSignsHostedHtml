<?php
  require_once('shared_functions.php');
  $action = $_GET['action'];

  switch (strtolower($action)) {
    case 'soft':
    case 'softreboot':
      exec('killall omxplayer omxplayer.bin videoplayer'); 
      exec('killall -q iceweasel');
      $oldDir = getcwd();
      chdir('/home/pi/');
      exec('./setup --silent --nokill 2>&1');
      chdir($oldDir);
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

