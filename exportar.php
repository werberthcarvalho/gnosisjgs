<?php
$host = 'localhost';
$dbname = 'inscricao';
$user = 'root';
$pass = ''; // Adicione sua senha se tiver

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=inscritos.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['Nome', 'Email', 'WhatsApp', 'Participou', 'Origem', 'Data']);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $sql = "SELECT nome, email, whatsapp, participou, origem, datahora FROM inscritos ORDER BY datahora DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $origem = json_decode($row['origem'], true);
        if (is_array($origem)) {
            $origem = implode(', ', $origem);
        }
        fputcsv($output, [
            $row['nome'],
            $row['email'],
            $row['whatsapp'],
            $row['participou'],
            $origem ?: $row['origem'],
            $row['datahora']
        ]);
    }
} catch (PDOException $e) {
    echo 'Erro ao conectar: ' . $e->getMessage();
}
?>
