<?php

function base_url(){
    $url = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	return substr($url, 0, -1);
}

function debug($data, $die = true)
{
    echo '<pre style="background-color:#191919;color:white;padding:10px;border:3px solid #AEC5EB;border-radius:15px">';
    if (is_array($data) || is_object($data)) {
        print_r($data);
    } else {
        echo $data;
    }
    echo '</pre>';
    if ($die) die;
}

function db(){
    $database = new DataBase();
    return $database;
}