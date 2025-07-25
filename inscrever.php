<?php
// Configurações do banco de dados
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "inscricao";

// Conexão com o banco
$conn = new mysqli($host, $usuario, $senha, $banco);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Função para limpar e validar entrada
function limpar($dado) {
    return htmlspecialchars(trim($dado));
}

// Coleta e validação dos dados do formulário
$nome = isset($_POST['nome_completo']) ? limpar($_POST['nome_completo']) : '';
$email = isset($_POST['email']) ? limpar($_POST['email']) : '';
$telefone = isset($_POST['telefone']) ? limpar($_POST['telefone']) : '';
$participou = isset($_POST['participou_evento']) ? limpar($_POST['participou_evento']) : '';
$origens = isset($_POST['origem_contato']) ? implode(',', $_POST['origem_contato']) : '';

// Verifica campos obrigatórios
if (empty($nome) || empty($email) || empty($telefone) || empty($participou)) {
    echo "<h3>Preencha todos os campos obrigatórios!</h3>";
    echo "<p><a href='index.html#register'>Voltar</a></p>";
    exit;
}

// Inserção segura com prepared statement
$stmt = $conn->prepare("INSERT INTO participantes (nome_completo, email, telefone, participou_evento, origem_contato) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nome, $email, $telefone, $participou, $origens);

if ($stmt->execute()) {
    echo "<h3>Inscrição realizada com sucesso!</h3>";
    echo "<p><a href='index.html'>Voltar para o site</a></p>";
} else {
    echo "Erro ao inserir: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
