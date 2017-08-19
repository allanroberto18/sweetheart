<?php

require __DIR__ . "/vendor/autoload.php";

if(!session_id()) {
    session_start();
}

function getPDO()
{
    return new PDO('mysql:dbname=facebook_db;host=localhost', 'homestead', 'secret');
}