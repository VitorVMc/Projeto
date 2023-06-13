<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Análise de Dados - OnTarget</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .back-button {
            margin-bottom: 20px;
        }
        .data-analysis-content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
        }
        p {
            margin-bottom: 20px;
        }
        .chart {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Análise de Dados</h1>
        <p>Aqui você pode obter insights valiosos sobre os seus clientes e as suas interações para tomar decisões estratégicas de negócio.</p>
        
        <div class="data-analysis-content">
            <h2>Análise de Vendas</h2>
            <p>Acompanhe o desempenho de vendas da sua empresa ao longo do tempo.</p>
            <div class="chart">
                <canvas id="salesChart"></canvas> 
            </div>
            <form id="salesForm">
                <div class="form-group">
                    <label for="salesData">Dados de vendas (separe por vírgulas):</label>
                    <input type="text" class="form-control" id="salesData" placeholder="Exemplo: 100, 150, 200, 180, 250, 300">
                </div>
                <button type="submit" class="btn btn-primary">Atualizar Gráfico</button>
            </form>
        </div>
        
        <div class="data-analysis-content">
            <h2>Análise de Clientes</h2>
            <p>Entenda melhor o perfil e comportamento dos seus clientes.</p>
            <div class="chart">
                <canvas id="customerChart"></canvas> 
            </div>
            <form id="customerForm">
                <div class="form-group">
                    <label for="customerData">Dados de compras (separe por vírgulas):</label>
                    <input type="text" class="form-control" id="customerData" placeholder="Exemplo: 5, 3, 7, 2, 9">
                </div>
                <button type="submit" class="btn btn-primary">Atualizar Gráfico</button>
            </form>
        </div>
        
        <a href="welcome.php" class="btn btn-secondary back-button">Voltar</a>
    </div>
    
    <!-- Biblioteca de gráficos (exemplo usando Chart.js) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Função para atualizar o gráfico de vendas com base nos dados fornecidos pelo usuário
        function updateSalesChart(event) {
            event.preventDefault(); // Impede o envio do formulário
            const salesDataInput = document.getElementById('salesData');
            const salesData = salesDataInput.value.trim().split(',').map(Number);
            salesChart.data.datasets[0].data = salesData;
            salesChart.update();
        }
        
        // Função para atualizar o gráfico de clientes com base nos dados fornecidos pelo usuário
        function updateCustomerChart(event) {
            event.preventDefault(); // Impede o envio do formulário
            const customerDataInput = document.getElementById('customerData');
            const customerData = customerDataInput.value.trim().split(',').map(Number);
            customerChart.data.datasets[0].data = customerData;
            customerChart.update();
        }

        // Gráfico de análise de vendas
        var salesChart = new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                datasets: [{
                    label: 'Vendas',
                    data: [100, 150, 200, 180, 250, 300],
                    backgroundColor: 'rgba(0, 123, 255, 0.3)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 2,
                    fill: 'start'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Gráfico de análise de clientes
        var customerChart = new Chart(document.getElementById('customerChart'), {
            type: 'bar',
            data: {
                labels: ['Cliente A', 'Cliente B', 'Cliente C', 'Cliente D', 'Cliente E'],
                datasets: [{
                    label: 'Compras',
                    data: [5, 3, 7, 2, 9],
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });

        // Adiciona os ouvintes de eventos aos formulários
        document.getElementById('salesForm').addEventListener('submit', updateSalesChart);
        document.getElementById('customerForm').addEventListener('submit', updateCustomerChart);
    </script>
</body>
</html>
