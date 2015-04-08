<?php

//Grab the autoloader
require "vendor/autoload.php";

//Rename the config file
rename("Config/config.example.php", "Config/config.php");

//Fill the config file with dummy (testable) config settings
$config = '<?php

return [

    "Providers" => [
        
        [
        
            "name"              => "Wordpress",
            "active"            => true,
            "nickname"          => "wp",
            "url"               => "http://localhost",
            "username"          => "user",
            "password"          => "pass",
            "provider_class"    => "Wordpress"
        
        ]
    
    ],
    
    "Groups" => [
    
        "ExGroup" => [
        
            "wp"
            
        ]
        
    ]

]

?>';

file_put_contents("Config/config.php", $config);