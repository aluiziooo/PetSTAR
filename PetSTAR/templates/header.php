<?php
    require_once("globals.php");
    require_once("db.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    $message = new Message($BASE_URL);

    $flashMessage= $message->getMessage();

    if(!empty($flashMessage["msg"])){
        //limpar mensassem
        $message -> clearMessage();
    }

    $userDAO = new UserDAO($conn, $BASE_URL);

    $userData = $userDAO->verifyToken(false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETSTAR</title>
    <!--BOOTSTRAP-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.css" integrity="sha512-VcyUgkobcyhqQl74HS1TcTMnLEfdfX6BbjhH8ZBjFU9YTwHwtoRtWSGzhpDVEJqtMlvLM2z3JIixUOu63PNCYQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--CSS do projeto-->
    <link rel="stylesheet" href="<?php $BASE_URL?>css/styles.css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <nav id="main-navbar" class="navbar navbar-expand-lg">
            <a href="<?php $BASE_URL?>index.php" class="navbar-brand">
                <img src="img/logo.svg" alt="PetStar" id="logo">
                <span id="petstar-title">
                    PetStar
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toogle navigation">
                <i class="fas fas-bars"></i>
            </button>
            <form action="" method="GET" id="search-form" class="form-inline my-2 my-lg-0">
                <input type="text" name="q" id="search" class="form-control mr-sm-2" type="search" placeholder="Buscar Pets" aria-label="Search">
                <button class="btn my-2 my-sm-0 btn-pesquisar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav">
                    <?php if($userData):?>
                        <li class="nav-item">
                            <a href="<?php $BASE_URL?>newpet.php" class="nav-link"><i class="far fa-plus-square"></i> Incluir Pet</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php $BASE_URL?>dashboard.php" class="nav-link">Meus Pets</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php $BASE_URL?>editprofile.php" class="nav-link bold"><?php echo $userData->name; ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php $BASE_URL?>logout.php" class="nav-link">Sair</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="<?php $BASE_URL?>auth.php" class="nav-link">Entrar / Cadastrar</a>
                        </li>
                    <?php endif;?>
                </ul>
            </div>
        </nav>
    </header>
    <?php if(!empty($flashMessage["msg"])): ?>
        <div class="msg-container">
            <p class="msg <?php echo $flashMessage["type"]?>"><?php echo $flashMessage["msg"]?></p>
        </div>
    <?php endif;?>

    