<?php
    // Inicialize a sessão
    session_start();
    
    // Verifique se o usuário está logado, se não, redirecione-o para uma página de login
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem vindo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #333;
            color: #fff;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .crm-features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
            margin-top: 40px;
        }
        .crm-feature {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
            background-color: #f9f9f9;
        }
        .crm-feature h2 {
            margin-top: 0;
        }
        .footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .float-right {
            position: fixed;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-5">Oi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Bem vindo ao OnTarget.</h1>
        <p>O OnTarget é um sistema de gerenciamento de relacionamento com o cliente que ajuda a sua empresa a manter e melhorar os relacionamentos com os clientes.</p>
        
        <div class="crm-features">
            <div class="crm-feature">
                <h2>Gerenciamento de Contatos</h2>
                <p>Armazene todas as informações relevantes sobre os seus contatos, incluindo nome, endereço, telefone, e-mail e muito mais.</p>
                <a href="contacts.php" class="btn btn-primary">Ir para Contatos</a>
            </div>
            <div class="crm-feature">
                <h2>Registro de Atividades</h2>
                <p>Acompanhe todas as interações e atividades realizadas com os clientes, como ligações, reuniões, e-mails e notas.</p>
                <br><br>
                <a href="activity.php" class="btn btn-primary">Ir para Registro de Atividades</a>
            </div>
            <div class="crm-feature">
                <h2>Análise de Dados</h2>
                <p>Obtenha insights valiosos sobre os seus clientes e as suas interações para tomar decisões estratégicas de negócio.</p><br><br>
                <a href="analise-dados.php" class="btn btn-primary">Obter Insights</a>
            </div>
        </div>
        
    </div>
    <p>
        <div class="float-right">
            <a href="reset-password.php" class="btn btn-warning">Redefina sua senha</a>
            <a href="logout.php" class="btn btn-danger ml-3">Sair da conta</a>
        </div>
    </p>
</body>
</html>
