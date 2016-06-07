<?php
  $result_set = array();

  $result_set['bootTime'] = exec("echo $(($(date +%s)-$( awk '{print int($1)}' /proc/uptime)))");
  addCommandCheck($result_set, 'cec-client');
  addCommandCheck($result_set, 'iceweasel', 'unclutter');
  addCommandCheck($result_set, 'php', 'apache2');

  $result_set['rotation'] = preg_pop_file('/^display_rotate=(\d+)$/', '/boot/config.txt')[1] * 90;
  
  $result_set['site'] = preg_pop_file('/iceweasel ([\w\/\:\.\,]+) /', '/home/pi/.config/lxsession/LXDE-pi/autostart')[1];
  
  exec("apachectl -t -D DUMP_MODULES 2>&1", $modules);
  $result_set['apache_modules'] = preg_grep_values('/^ (\w+)_module/', $modules);

  echo json_encode($result_set, JSON_PRETTY_PRINT);

  function addCommandCheck(&$result_set, $commands='') {
    $commands = array_splice(func_get_args(), 1);
    foreach ($commands as $command) { 
      $result_set[$command] = (bool) exec("command -v $command");
    }
  }

  function preg_grep_values($pattern, $array) {
    $array = preg_grep($pattern, $array);
    foreach ($array as &$value) {
      preg_match($pattern, $value, $matches);
      $value = $matches[1];
    }
    return array_values($array);
  }

  function preg_pop($pattern, $array) {
    preg_match($pattern, array_pop(preg_grep($pattern, $array)), $matches);
    return $matches;
  }
  
  function preg_pop_file($pattern, $file) {
    return preg_pop($pattern, file($file));
  }
?>
