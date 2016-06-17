<?php
  require_once('shared_functions.php');
  $result_set = array();

  $result_set['bootTime'] = get_bootTime();
  addCommandCheck($result_set, 'cec-client');
  addCommandCheck($result_set, 'iceweasel', 'unclutter');
  addCommandCheck($result_set, 'php', 'apache2');

  $result_set['rotation'] = get_rotation();
  
  $result_set['site'] = get_bootSite();
  
  $result_set['apache_modules'] = get_apacheModules();

  echo json_encode($result_set, JSON_PRETTY_PRINT);

  function addCommandCheck(&$result_set, $commands='') {
    $commands = array_splice(func_get_args(), 1);
    foreach ($commands as $command) { 
      $result_set[$command] = get_commandExists($command);
    }
  }
?>
