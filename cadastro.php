<?php
    session_start();
    include_once("connection.php");

    $letters_list = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
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
    <title>Cadastro</title>
</head>
<body>
    <div class="header">
        <div class="links">
            <a href="adm_index.php">Tela inicial</a>
            <a href="login.php">Login</a>
        </div>
        <div class="title">Cadastro</div>
    </div>

    <div class="main">
        <?php
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                $username = $_POST["username"];
                $name = $_POST["name"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $user_type = $_POST["user_type"];
                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                
                //primeiro vê se o usuario ou email já existe no bd
                $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $username, $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='wrong-password'>Ops, já existe uma conta com esse nome de usuário ou e-mail, tente outro.</div><br><br>";
                }
                else{
                    $sql = "INSERT INTO users(username, name, email, password, user_type, status, is_first_time) VALUES (?, ?, ?, ?, ?, 'A', 1)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssss", $username, $name, $email, $hash_password, $user_type);

                    if ($stmt->execute()) {
                        echo "Usuário cadastrado com sucesso!";
                        header("Location: index.php");
                    } else {
                        echo "Algo deu errado por nossa parte...";
                    }
                }
            }
        ?>
        <div class="form-group">
            <div class="frog-image">
            </div>
            <div class="form-content">
                <form method="post">
                    Username<br>
                    <input class="form-input" type="text" name="username" max="30" required>
                    <br><br>
                    Nome<br>
                    <input class="form-input" type="text" name="name" max="90" required>
                    <br><br>
                    Email<br>
                    <input class="form-input" type="email" name="email" max="200" required>
                    <br><br>
                    Senha<br>
                    <div class="password-container">
                        <input class="password-input" id="senha" type="text" name="password" required>
                        <button class="password_button" type="button" onclick="gerarSenha()">Gerar senha</button>
                    </div>
                    <br>
                    Tipo de usuário<br>
                    <select class="select-input" name="user_type" required>
                        <option value="U">Usuário</option>
                        <option value="A">Administrador</option>
                    <input type="submit" name="submit" value="Cadastrar">
                </form>
            </div>
        </div>
    </div>

    <script>
        function gerarSenha() {
            const caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%&";
            let senha = "";
            for (let i = 0; i < 8; i++) {
                const index = Math.floor(Math.random() * caracteres.length);
                senha += caracteres[index];
            }
            document.getElementById("senha").value = senha;
        }
    </script>
</body>
</html>