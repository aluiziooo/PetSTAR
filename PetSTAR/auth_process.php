<?php
    
    require_once("globals.php");
    require_once("db.php");
    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    $message = new message($BASE_URL);
    $userDAO = new UserDAO($conn, $BASE_URL);

    // resgata o tipo de formulario
    $type = filter_input(INPUT_POST, "type");

    // Verificacao do tipo de formulario
    if($type === "register"){

        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

        // verificação de dados minimos
        if($name && $lastname && $email && $password){
            if($password === $confirmpassword){
                // verificar se o email já esta cadastrado no sistema
                if($userDAO->findByEmail($email) === false){
                    
                    $user = new User();

                    //criação de token e senha
                    $userToken = $user->generateToken();
                    $finalPassword = $user->generatePassword($password);

                    $user->name = $name;
                    $user->lastname = $lastname;
                    $user->email = $email;
                    $user->password = $finalPassword;
                    $user->token = $userToken;
                    
                    $auth = true;

                    $userDAO->create($user, $auth);


                } else{
                    //enviar mensagem de error, usuario já existe
                    $message->setMessage("Usuario já cadastrado, tente outro e-mail.", "error", "back");
                }
            } else {
                //enviar mensagem de error password e confirmpassword não são iguais
                $message->setMessage("Os campos senha e confirmação de senha devem ser iguais", "error", "back");
            }

        } else {
            //Enviar mensagem de error por falta de dados
            $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
        }

    } else if($type === "login"){

        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        //tenta autencicar usuario

        if($userDAO->authenticateUser($email, $password)){
            
            $message->setMessage("Seja Bem-vindo", "success", "editprofile.php");

        // redireciona o usuario, caso não consiga autenticar
        } else {

            $message->setMessage("Usuario e/ou senha incorreto(s)", "error", "back");
        }
    } else {
        $message->setMessage("Informações invalidas.", "error", "index.php");
    }