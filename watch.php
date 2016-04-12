<?php

require_once 'vendor/PHP-JS-CSS-Minifier/minifier.php';

$dir = $argv[1];

if(!$dir){
    exit;
}

while(true){
    $files = scandir($dir);

    foreach($files as $file){
        $source_file = $dir.'/'.$file;

        // min.jsを無視する
        if(preg_match('/^[\w\-_.]+.min.js$/', $file, $match)){
            continue;
        }

        // .jsじゃないファイルを無視する
        if(!preg_match('/^([\w\-_.]+).js$/', $file, $match)){
            continue;
        }

        $js_file = $match[1];

        $is_gen = false;

        $target_file = $dir.'/'.$js_file.'.min.js';
        if(!file_exists($target_file)){
            $is_gen = true;
        }else {

            if (filemtime($source_file) > filemtime($target_file)) {
                $is_gen = true;
            }
        }

        if($is_gen){
            echo "Generating $target_file\n";

            $js_mapping = array($source_file => $target_file);

            minifyJS($js_mapping);
        }

    }

    sleep(1);
}


