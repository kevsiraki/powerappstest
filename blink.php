<?php

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If it's POST, proceed with execution
    echo json_encode(["message" => "Hi from an LED!"]);
    
    $bashScriptPath = '/home/pico_commands/on.sh';
    
    // Execute the shell command
    shell_exec("bash $bashScriptPath 5 0 255 0 1");
    
    // Wait for 5 seconds
    sleep(5);
    
    // Turn off the commands
    shell_exec("bash $bashScriptPath 5 0 0 0 0");
} else {
    // If the request method is not POST, return an error message
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Method not allowed."]);
}
?>
