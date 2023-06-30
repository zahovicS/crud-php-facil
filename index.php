<?php

require_once "./includes/bootstrap.php";

$messages = getFlashMessage();

$usuarios = db()->queryExecute("SELECT * FROM usuarios")->queryGetAllResult();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css" integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/custom.css">
</head>

<body>
    
    <div id="layout">
        <!-- Menu toggle -->
        <a href="#menu" id="menuLink" class="menu-link">
            <!-- Hamburger icon -->
            <span></span>
        </a>

        <div id="menu">
            <div class="pure-menu">
                <a class="pure-menu-heading" href="#company">Admin</a>

                <ul class="pure-menu-list">
                    <li class="pure-menu-item"><a href="#" class="pure-menu-link">Usuarios</a></li>
                </ul>
            </div>
        </div>

        <div id="main">
            <div class="header">
                <h1>Lista de usuarios</h1>
            </div>
            <div class="content">
                <?php if ($messages) : ?>
                    <div class="alert alert-<?= $messages["type"] ?>">
                        Mensaje:<br />
                        <?= $messages["message"] ?>
                    </div>
                <?php endif; ?>
                <table class="pure-table pure-table-horizontal">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>nombre</th>
                            <th>correo</th>
                            <th>acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $key => $usuario): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $usuario->nombre ?></td>
                                <td><?= $usuario->email ?></td>
                                <td>
                                    <a href="<?= base_url() ?>/api/Usuarios.php?action=editar&usuario_id=<?= $usuario->usuario_id ?>" class="pure-button button-secondary">Editar</a>
                                    <?= $usuario->usuario_id ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="<?= base_url() ?>/assets/js/main.js"></script>
</body>

</html>