<?php

use Slim\App;
use App\Framework\Config\_Global;

return function (App $app,_Global $global) {
    foreach (scandir($path =  __DIR__  . '/../Modules') as $dir) {
        if (file_exists($filepath = "{$path}/{$dir}/Presentation/Routes/api.php")) {
             (require $filepath)($app,$global);
        }
    }
};