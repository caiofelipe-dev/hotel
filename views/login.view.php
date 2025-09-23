<?php

use Fmk\Facades\CSRF;
use Fmk\Facades\Request;
use Fmk\Facades\Session;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="/logar" method="POST">
        <input type="text" name="nome"><br>
        <input hidden type="text" name="<?=CSRF::TOKEN_NAME?>" value="<?=Session::getInstance()->{CSRF::TOKEN_NAME}?>"><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>