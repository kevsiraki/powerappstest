<?php
echo json_encode(["message" => "Hi."]);
$bashScriptPath = '/home/pico_commands/on.sh';
shell_exec("bash $bashScriptPath 5 0 255 0 1");
sleep(1);
shell_exec("bash $bashScriptPath 5 0 0 0 0");
?>