<?php
session_start();

// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Verifique se o formulário de registro de atividades foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processar os dados do formulário
    $atividade = $_POST["atividade"];
    $data = $_POST["data"];
    $hora = $_POST["hora"];
    $descricao = $_POST["descricao"];

    // Obtenha o ID do usuário logado
    $usuario_id = $_SESSION["usuario_id"];

    // Conectar ao banco de dados
    $mysqli = new mysqli("localhost", "root", "", "test");

    // Verificar a conexão
    if ($mysqli->connect_error) {
        die("Falha na conexão com o banco de dados: " . $mysqli->connect_error);
    }

    // Preparar a consulta SQL para inserção
    $sql = "INSERT INTO atividades (atividade, data, hora, descricao, usuario_id) VALUES (?, ?, ?, ?, ?)";

    // Preparar a declaração
    $stmt = $mysqli->prepare($sql);

    // Verificar se a preparação da declaração foi bem-sucedida
    if ($stmt) {
        // Vincular os parâmetros da declaração
        $stmt->bind_param("ssssi", $atividade, $data, $hora, $descricao, $usuario_id);

        // Executar a declaração
        if ($stmt->execute()) {
            // Redirecionar para a página de atividades ou exibir uma mensagem de sucesso
            header("location: activities.php");
            exit;
        } else {
            // Exibir uma mensagem de erro em caso de falha na execução da declaração
            echo "Erro ao executar a declaração: " . $stmt->error;
        }

        // Fechar a declaração
        $stmt->close();
    } else {
        // Exibir uma mensagem de erro em caso de falha na preparação da declaração
        echo "Erro ao preparar a declaração: " . $mysqli->error;
    }

    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registro de Atividades</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .proximas-reunioes {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }

        .proximas-reunioes h2 {
            margin-bottom: 10px;
        }

        .proximas-reunioes ul {
            list-style-type: none;
            padding: 0;
        }

        .proximas-reunioes li {
            margin-bottom: 10px;
            font-size: 14px;
            line-height: 1.4;
        }

        .proximas-reunioes li strong {
            font-weight: bold;
        }

        .proximas-reunioes li a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-5">Registro de Atividades</h1>
        <form action="activity.php" method="post">
            <div class="form-group">
                <label for="atividade">Atividade:</label>
                <input type="text" id="atividade" name="atividade" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="data">Data:</label>
                <input type="date" id="data" name="data" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="hora">Hora:</label>
                <input type="time" id="hora" name="hora" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" class="form-control" required></textarea>
            </div>
            <button type="button" onclick="gerarLinkReuniao()" class="btn btn-primary">Registrar Atividade</button>
        </form>

        <div class="proximas-reunioes">
            <h2>Próximas Reuniões</h2>
            <ul id="lista-reunioes"></ul>
        </div>
        <a href="welcome.php" class="btn btn-secondary back-button">Voltar</a>
    </div>

    <script>
        function gerarLinkReuniao() {
            // Obtenha a data e hora da reunião
            var dataReuniao = document.getElementById("data").value;
            var horaReuniao = document.getElementById("hora").value;

            // Formate a data e hora no formato esperado pelo Google Meet
            var dataHoraFormatada = dataReuniao + "T" + horaReuniao + ":00";

            // URL base do Google Meet
            var urlBase = "https://meet.google.com/";

            // Gere um código de reunião aleatório
            var codigoReuniao = generateMeetingCode(10);

            function generateMeetingCode(length) {
                var characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                var code = '';

                for (var i = 0; i < length; i++) {
                    var randomIndex = Math.floor(Math.random() * characters.length);
                    code += characters.charAt(randomIndex);
                }

                return code;
            }

            // Crie o link completo da reunião
            var linkReuniao = urlBase + codigoReuniao + "?date=" + dataHoraFormatada;

            // Exiba o link da reunião
            alert("Link da Reunião: " + linkReuniao);

            // Adicione a reunião à lista de próximas reuniões
            var listaReunioes = document.getElementById("lista-reunioes");
            var novaReuniao = document.createElement("li");
            novaReuniao.innerHTML = "<strong>Data e Hora:</strong> " + dataHoraFormatada + " - <a href='" + linkReuniao + "'>Link</a>";
            listaReunioes.appendChild(novaReuniao);
        }
    </script>
</body>
</html>
