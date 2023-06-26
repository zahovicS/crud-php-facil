<?php

require_once "../../includes/bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST["action"] == "guardar") {
        debug($_POST);
    }
}