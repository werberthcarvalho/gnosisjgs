<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "inscricao";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="inscricoes.csv"');

$output = fopen("php://output", "w");
fputcsv($output, ['ID', 'Nome Completo', 'Email', 'Telefone', 'Participou Evento', 'Origem', 'Data']);

$result = $conn->query("SELECT * FROM participantes");
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$conn->close();
?>
