<?php

require_once "./includes/bootstrap.php";

// $result = db()->queryExecute("SELECT * FROM usuarios")->queryGetAllResult();
// debug($result);

$messages = getFlashMessage();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css" integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/custom.css">
</head>

<body>
    <section class="section">
        <?php if($messages): ?>
            <div class="alert alert-<?= $messages["type"] ?>">
                Mensaje:<br/>
                <?= $messages["message"] ?>
            </div>
        <?php endif; ?>
        <h2>Registro de usuario</h2>
        <form action="<?= base_url()?>/api/Usuarios.php" method="POST">
            <input type="hidden" name="action" value="guardar">
            <div class="row">
                <div class="four columns">
                    <label for="nombreInput">Tu nombre</label>
                    <input class="u-full-width" name="nombre" type="text" placeholder="Illojuan" id="nombreInput">
                </div>
                <div class="four columns">
                    <label for="correoInput">Tu correo</label>
                    <input class="u-full-width" name="email" type="email" placeholder="test@mailbox.com" id="correoInput">
                </div>
                <div class="four columns">
                    <label for="contrasenaInput">Tu contraseña</label>
                    <input class="u-full-width" name="contrasena" type="password" id="contrasenaInput">
                </div>
            </div>
            <button type="submit" class="button-primary">Enviar</button>
        </form>
    </section>
</body>

</html>