<?php

// APP
define("BASE_DIR", __DIR__);

// DATABASE
define("DATA_BASE_HOST", "localhost");
define("DATA_BASE_NAME", "test");
define("DATA_BASE_USER", "root");
define("DATA_BASE_PORT", "3306");
define("DATA_BASE_CHARSET", "UTF-8");
define("DATA_BASE_PASSWORD", "root");
define("DATA_BASE_OPTIONS", extension_loaded('pdo_mysql') ? array_filter([
    PDO::ATTR_CASE => PDO::CASE_LOWER,
    PDO::CASE_LOWER => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]) : []);

