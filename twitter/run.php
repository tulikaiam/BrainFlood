<html>
<?php
set_time_limit(60);
$output = shell_exec("python application.py");
echo (($output).'\n');


?>
</html>