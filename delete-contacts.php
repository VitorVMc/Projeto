<?php
session_start();

// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Verifique se o parâmetro de ID está presente na URL
if (isset($_GET["id"])) {
    $contactId = $_GET["id"];

    // Conexão com o banco de dados
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

    // Preparar e executar a consulta para excluir o contato do banco de dados
    $stmt = $conn->prepare("DELETE FROM contatos WHERE nome = ?");
    $stmt->bind_param("s", $contactId);

    if ($stmt->execute()) {
        // Exclusão bem-sucedida, redirecione de volta para a página de contatos
        header("location: contacts.php");
        exit;
    } else {
        echo "Erro ao excluir o contato do banco de dados: " . $stmt->error;
    }

    // Fechar a conexão e liberar os recursos
    $stmt->close();
    $conn->close();
} else {
    // Redirecione para a página de contatos se o parâmetro de ID não estiver presente
    header("location: contacts.php");
    exit;
}
