<?php
// Configuração de conexão
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "inscricao";

// Conecta ao banco
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Pega dados do formulário
$nome = $_POST['nome_completo'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$participou = $_POST['participou_evento'];
$origens = isset($_POST['origem_contato']) ? implode(",", $_POST['origem_contato']) : "";

// Prepara e executa inserção
$stmt = $conn->prepare("INSERT INTO participantes (nome_completo, email, telefone, participou_evento, origem_contato) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nome, $email, $telefone, $participou, $origens);

if ($stmt->execute()) {
    echo "<h3>Inscrição realizada com sucesso!</h3>";
    echo "<p><a href='formulario.html'>Voltar</a></p>";
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
