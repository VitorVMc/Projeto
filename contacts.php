<?php
session_start();

// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Verifique se o formulário de adicionar contato foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processar os dados do formulário
    $nome = $_POST["nome"];
    $endereco = $_POST["endereco"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];

    // Salvar os dados do contato no banco de dados
    $servername = "localhost"; 
    $username = "root"; 
    $password = "";    
    $dbname = "test";      

    // Criar conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Preparar e executar a consulta para inserir o contato no banco de dados
    $stmt = $conn->prepare("INSERT INTO contatos (nome, endereco, telefone, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $endereco, $telefone, $email);

    if ($stmt->execute()) {
        // Inserção bem-sucedida, redirecione para a página de contatos
        header("location: contacts.php");
        exit;
    } else {
        echo "Erro ao inserir o contato no banco de dados: " . $stmt->error;
    }

    // Fechar a conexão e liberar os recursos
    $stmt->close();
    $conn->close();
}

// Recuperar os contatos armazenados no banco de dados
$servername = "localhost";  // substitua pelo nome do servidor MySQL
$username = "root";  // substitua pelo nome de usuário do MySQL
$password = "";    // substitua pela senha do MySQL
$dbname = "test";      // substitua pelo nome do banco de dados

// Criar conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Consultar os contatos salvos no banco de dados
$sql = "SELECT nome, endereco, telefone, email FROM contatos";
$result = $conn->query($sql);

// Armazenar os contatos em uma array
$contacts = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contacts[] = $row;
    }
}

// Fechar a conexão e liberar os recursos
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnTarget</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .crm-feature {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 4px;
        }

        h2 {
            margin-top: 0;
        }

        h3 {
            margin-top: 20px;
        }

        hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #ccc;
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

        ul {
            list-style-type: none;
            padding-left: 0;
            margin-top: 0;
        }

        li {
            margin-bottom: 10px;
        }

        strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="crm-feature">
    <h2>Gerenciamento de Contatos</h2>
    <p>Armazene todas as informações relevantes sobre os seus contatos, incluindo nome, endereço, telefone, e-mail e muito mais.</p>
    <hr>
    <h3>Adicionar Novo Contato</h3>
    <form action="contacts.php" method="post">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Contato</button>
    </form>
    <hr>
    <h3>Contatos Salvos</h3>
    <?php if (empty($contacts)) : ?>
        <p>Nenhum contato encontrado.</p>
        <a href="welcome.php" class="btn btn-secondary back-button">Voltar</a>
    <?php else : ?>
        <ul>
            <?php foreach ($contacts as $contact) : ?>
                <li>
                    <strong><?php echo $contact["nome"]; ?></strong><br>
                    <strong>Endereço:</strong> <?php echo $contact["endereco"]; ?><br>
                    <strong>Telefone:</strong> <?php echo $contact["telefone"]; ?><br>
                    <strong>E-mail:</strong> <?php echo $contact["email"]; ?><br>
                    <a href="delete-contacts.php?id=<?php echo $contact['nome']; ?>" class="btn btn-primary">Excluir<a>           
                </li>
                <br>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
</body>
</html>
