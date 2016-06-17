<?php
  function get_apacheModules() {
    exec("apachectl -t -D DUMP_MODULES 2>&1", $modules);
    return preg_grep_values('/^ (\w+)_module/', $modules);
  }

  function get_bootTime() {
    return exec("echo $(($(date +%s)-$( awk '{print int($1)}' /proc/uptime)))");
  }

  function get_bootSite() {
    return preg_pop_file('/iceweasel ([\w\/\:\.\,]+) /', '/home/pi/.config/lxsession/LXDE-pi/autostart')[1];
  }

  function get_rotation() {
    return preg_pop_file('/^display_rotate=(\d+)$/', '/boot/config.txt')[1] * 90;
  }  

  function get_commandExists($command) {
    return (bool) exec("command -v $command");
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
