<?php
    session_start();
    include_once("connection.php");
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
            <a href="login.php">Cadastro</a>
        </div>
        <div class="title">Login</div>
    </div>

    <div class="main">
        <div class="main-title">Notamos que é sua primeira vez aqui!</div><br>
        <div class="main-title">Para entrar na sua conta, crie uma senha :)</div><br>
        <div class="form-group">
            <div class="frog-image">
            </div>
            <div class="form-content-first-time">
                <form method="post">
                    Senha<br>
                    <input class="form-input" type="password" name="password" placeholder="digite sua nova senha aqui" required>
                    <br><br>
                    <input type="submit" name="submit" value="Cadastrar nova senha e entrar!">
                </form>
            </div>
        </div>
    </div>

    <?php
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $username = $_SESSION['username'];
            $password = $_POST["password"];
            $is_first_time = 0; //não é mais a primeira vez

            $sql = "UPDATE users SET password = ?, is_first_time = ? WHERE username = ?";
            $query = $conn->prepare($sql);

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query->bind_param("sis", $hashed_password, $is_first_time, $_SESSION['username']);

            if($query->execute()){ 
                $query = $conn->prepare("SELECT * FROM users WHERE username = ?");
                $query->bind_param("s", $username);
                $query->execute();
                $result = $query->get_result();
                $user = $result->fetch_assoc();

                if($user['user_type'] == 'A') {
                    header("Location: adm_index.php");
                } else {
                    header("Location: index.php");
                }
            } else {
                echo "Erro ao atualizar a senha. Tente novamente.";
            }

        }
    ?>

</body>
</html>