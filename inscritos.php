<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "inscricao";

// Conexão
$conn = new mysqli($host, $usuario, $senha, $banco);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Consulta
$sql = "SELECT * FROM participantes ORDER BY data_inscricao DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Inscritos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2 class="mb-4">Inscrições - Palestra Gnosis Jaraguá do Sul</h2>
    <?php if ($resultado->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Participou antes?</th>
                        <th>Origem</th>
                        <th>Data da Inscrição</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row["id"] ?></td>
                            <td><?= htmlspecialchars($row["nome_completo"]) ?></td>
                            <td><?= htmlspecialchars($row["email"]) ?></td>
                            <td><?= htmlspecialchars($row["telefone"]) ?></td>
                            <td><?= $row["participou_evento"] ?></td>
                            <td><?= $row["origem_contato"] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($row["data_inscricao"])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>Nenhum inscrito até o momento.</p>
    <?php endif; ?>
</div>
</body>
</html>

<?php $conn->close(); ?>
