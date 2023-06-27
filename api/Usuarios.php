<?php

require_once "../includes/bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST["action"] == "guardar") {
        if (isEmptyInputRequest()) {
            setFlashMessage("Rellene los campos.","error");
            redirectBack();
        }
        $request = request();
        $request["contrasena"] = encryptPassword($request["contrasena"]);
        $exist = db()->isRowExists("usuarios","email",$request["email"]);
        if ($exist) {
            setFlashMessage("El email ya exsiste en la Base de datos.","error");
            redirectBack();
        }
        $result = db()->queryExecute("INSERT INTO usuarios (nombre, email, password) values (:nombre,:email,:contrasena)", $request);
        if (!$result->isSuccess()) {
            setFlashMessage($result->getError(),"error");
            redirectBack();
        }
        setFlashMessage("Usuario guardado correctamente.");
        redirectBack();
    }
    if ($_POST["action"] == "actualizar") {
        if (isEmptyInputRequest("email") || isEmptyInputRequest("nombre")) {
            setFlashMessage("Rellene los campos.","error");
            redirectBack();
        }
        $request = request();
        $valuesEdit = "nombre = :nombre, email = :email"; 
        if (isset($request["contrasena"])) {
            $valuesEdit .= ",password = :contrasena";
            $request["contrasena"] = encryptPassword($request["contrasena"]);
        }
        $result = db()->queryExecute("UPDATE usuarios SET {$valuesEdit} WHERE usuarios_id = :usuario_id", $request);
        if (!$result->isSuccess()) {
            setFlashMessage($result->getError(),"error");
            redirectBack();
        }
        setFlashMessage("Usuario editado correctamente.");
        redirectBack();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET["action"] == "editar") {
        redirect(base_url()."/guardar.php");
    }
    if ($_GET["action"] == "eliminar") {
        if (isEmptyInputRequest("usuario_id")) {
            setFlashMessage("No hay usuario.","error");
            redirectBack();
        }
        $request = request();
        
        $result = db()->queryExecute("DELETE FROM usuarios WHERE usuarios_id = :usuario_id", $request);
        if (!$result->isSuccess()) {
            setFlashMessage($result->getError(),"error");
            redirectBack();
        }
        setFlashMessage("Usuario eliminado correctamente.");
        redirectBack();
    }
}