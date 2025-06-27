<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Saída de Dados</title>
</head>
<body>
    <div class="header">
        <div class="left-side">
            <a href="index.php"><div class="logo"></div></a>
        </div>
    </div>
    <div class="main">
        <div class="output-group">
            <div class="top">
                <div class="output-client">
                    <?php
                        session_start();
                        echo "<h2>Informações do cliente</h2><br>";
                        echo $_SESSION["client_name"], "<br>";
                        echo $_SESSION["email"], "<br>";
                        echo $_SESSION["address"], "<br>";
                        echo $_SESSION["phone_number"], "<br>";
                    ?>
                </div>
                <div class="output-pet">
                    <?php
                        echo "<h2>Informações do pet</h2><br>";
                        echo $_SESSION["pet_name"], "<br>";
                        echo $_SESSION["owner_name"], "<br>";
                        echo $_SESSION["animal_type"], "<br>";
                        echo $_SESSION["pet_problem"], "<br>";
                    ?>
                    <br><br>
                    
                </div>
            </div>
            <div class="bottom">
                <a href="index.php"><button>Confirmar e enviar dados</button></a>
            </div>
        </div>
    </div>
</body>
</html>