<?php
    session_start();
    include_once("connection.php");

    if (!isset($_SESSION['wrong_password_tentatives'])) {
        $_SESSION['wrong_password_tentatives'] = 0;
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username = $_POST["username"];
        $password = $_POST["password"];

        $query = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $query->bind_param("s", $username); //o "s" fala que é uma string, em relação ao '?' do query
        $query->execute();

        $result = $query->get_result();
        $user = $result->fetch_assoc();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <div class="header">
        <div class="links">
            <a href="index.php">Tela inicial</a>
        </div>
        <div class="title">Login</div>
    </div>

    <div class="main">
        <div class="form-group">
            <div class="frog-image">
            </div>
            <div class="form-content-first-time">
                <form method="post">
                    Username<br>
                    <input class="form-input" type="text" name="username" required>
                    <br><br>
                    Senha<br>
                    <input class="form-input" type="password" name="password" required>
                    <?php
                        if($_SERVER["REQUEST_METHOD"]=="POST"){
                            if ($user) {
                                $stored_hashed_password = $user['password'];
                                if(password_verify($password, $stored_hashed_password)){
                                    echo "Login bem-sucedido!<br>";
                                    $_SESSION['username'] = $user['username'];

                                    if($user['is_first_time'] == 1) {
                                        header("Location: first_time_login.php");
                                    } else {
                                        if ($user['user_type'] == 'A') {
                                            $_SESSION['user_type'] = 'A';
                                            header("Location: adm_index.php"); //manda para a tela de adm
                                        }
                                        else {
                                            $_SESSION['user_type'] = 'U';
                                            header("Location: index.php");
                                        }
                                        
                                    }
                                } else {
                                    if ($user['status'] == 'I'){
                                        echo "<div class='wrong-password'>Sua conta está inativa. Fale com seu adm para ativar sua conta novamente.</div>";
                                        $_SESSION['wrong_password_tentatives'] = 0; //reseta
                                    }
                                    else{
                                        $_SESSION['wrong_password_tentatives'] += 1;
                                        if($_SESSION['wrong_password_tentatives'] >= 3) {
                                            echo "<div class='wrong-password'>Número máximo de tentativas excedidio. Fale com seu adm para ativar sua conta novamente.</div>";
                                            $_SESSION['wrong_password_tentatives'] = 0; //reseta

                                            $sql = "UPDATE users SET status = ? WHERE username = ?";
                                            $status = 'I'; //inativo
                                            $query = $conn->prepare($sql);
                                            $query->bind_param("ss", $status, $_POST['username']);

                                            if($query->execute()){
                                                echo 'conta inativada';
                                            }
                                        }
                                        else{
                                            echo "<div class='wrong-password'>Senha incorreta!</div><br>";
                                        }
                                    }
                                    
                                }
                            }
                            else {
                                echo "<div class='wrong-password'>Essa conta não existe, peça pro seu adm criar uma! (ou cadastre uma como adm)</div>";
                            }

                            
                        }
                        
                    ?>
                    <br>
                    <input type="submit" name="submit" value="Entrar">
                </form>
            </div>
        </div>
    </div>

    <?php
        
    ?>

</body>
</html>