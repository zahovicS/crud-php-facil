<?php

function base_url(){
    $url = "http://localhost/phpfast/";
    // $url = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	return substr($url, 0, -1);
}

function debug($data, $die = true)
{
    echo '<pre style="background-color:#191919;color:white;padding:10px;border:3px solid #AEC5EB;border-radius:15px">';
    var_dump($data);
    echo '</pre>';
    if ($die) die;
}

function db(){
    require_once "database.php";
    $database = new DataBase();
    return $database;
}

function validator(array $data,array $rules){
    require_once "validator.php";
    $database = new Validator();
    return $database->validate($data,$rules);
}

function sanitizeInput($input) {
    if (is_array($input)) {
        return array_map('sanitizeInput', $input);
    }
    
    // Sanitizar la entrada eliminando etiquetas HTML y caracteres especiales
    $sanitizedInput = trim(strip_tags($input));
    
    // Escapar caracteres especiales para prevenir ataques de inyección de código
    $sanitizedInput = addslashes($sanitizedInput);
    
    return $sanitizedInput;
}

function request(string $key = ""){
    $requestData = [];
    
    // Procesar los datos de $_GET
    if (!empty($_GET)) {
        foreach ($_GET as $key_g => $value) {
            if ($key_g !== 'action') {
                $requestData[$key_g] = sanitizeInput($value);
            }
        }
    }
    
    // Procesar los datos de $_POST
    if (!empty($_POST)) {
        foreach ($_POST as $key_p => $value) {
            if ($key_p !== 'action') {
                $requestData[$key_p] = sanitizeInput($value);
            }
        }
    }
    
    if ($key !== '') {
        return isset($requestData[$key]) ? $requestData[$key] : null;
    }
    
    return $requestData;
}

//verifica si hay una variable o key vacia o null en request()
function isEmptyInputRequest(string $key = ""): bool {
    $requestData = request();
    
    if ($key !== "") {
        return isEmptyInput($requestData[$key]);
    }
    
    foreach ($requestData as $value) {
        if (isEmptyInput($value)) {
            return true;
        }
    }
    
    return false;
}

//verifica si hay una variable o key vacia o null de un $input
function isEmptyInput($input) {
    if (is_array($input)) {
        foreach ($input as $value) {
            if (isEmptyInput($value)) {
                return true;
            }
        }
        return false;
    }

    return ($input === null || $input === '');
}

function setSessionValue($key, $value) {
    $_SESSION[$key] = $value;
}

function getSessionValue($key) {
    if (isset($_SESSION[$key])) {
        return $_SESSION[$key];
    }
    return null;
}

function setFlashMessage($message, $type = 'success') {
    setSessionValue('flash_message', $message);
    setSessionValue('flash_type', $type);
}

function unsetSessionValue($key) {
    unset($_SESSION[$key]);
}

function getFlashMessage() {
    $message = getSessionValue('flash_message');
    $type = getSessionValue('flash_type');

    unsetSessionValue('flash_message');
    unsetSessionValue('flash_type');

    if ($message) {
        return [
            'message' => $message,
            'type' => $type
        ];
    }

    return null;
}

function redirect($url) {
    header("Location: " . $url);
    exit();
}

function redirectBack() {
    if (isset($_SERVER['HTTP_REFERER'])) {
        $url = $_SERVER['HTTP_REFERER'];
        redirect($url);
    } else {
        redirect("/");
    }
}

function encryptPassword($password) {
    $hashedPassword = hash('sha256', $password);
    return $hashedPassword;
}