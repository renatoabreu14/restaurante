<?php
session_start();

include_once "../app/model/Usuario.php";
include_once "../app/controller/UsuarioController.php";

$usuario = new \model\Usuario();
$usuarioLogado = new \model\Usuario();

/*if (isset($_GET['id'])){
    $cliente = \controller\ClienteController::getInstance()->buscarCliente($_GET['id']);
}*/

if (isset($_POST['login'])){
    $usuario->setEmail($_POST['email']);
    $usuario->setPassword(md5($_POST['password']));

    $usuarioLogado = \controller\UsuarioController::getInstance()->login($usuario);

    if ($usuarioLogado->getNome() != null){
        $_SESSION['usuario'] = serialize($usuarioLogado);
        header('Location: listaClientes.php');
    }

    /*if (\controller\UsuarioController::getInstance()->login($usuario)){
        header('Location: login.php');
    }*/
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Seja bem vindo!</h1>
                                </div>
                                <?php
                                    if (($usuarioLogado->getNome() == null) && isset($_POST['login'])){
                                        echo "<div class=\"card mb-4 py-3 border-bottom-danger\">
                                                <div class=\"card-body\">
                                                    Usuário ou senha inválidos!
                                                </div>
                                            </div>";
                                    }
                                ?>
                                <form class="user" method="post" action="#">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Entre com seu email">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Senha">
                                    </div>
                                    <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="forgot-password.php">Esqueci a senha?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="register.php">Criar uma nova conta!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../js/sb-admin-2.min.js"></script>

</body>

</html>
