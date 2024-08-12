<?php
header('Content-Type: application/json');
include 'database.php'; // Inclua aqui a sua conexão com o banco de dados
 
$data = json_decode(file_get_contents('php://input'), true);
 
if (!isset($data['id']) || !isset($data['ddi']) || !isset($data['ddd']) || !isset($data['telefone'])) {
    echo json_encode(['error' => 'Dados insuficientes']);
    http_response_code(400);
    exit;
}
 
$id = $data['id'];
$ddi = $data['ddi'];
$ddd = $data['ddd'];
$telefone = $data['telefone'];
 
$query = "UPDATE telefones SET ddi = ?, ddd = ?, telefone = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('iiss', $ddi, $ddd, $telefone, $id);
 
if ($stmt->execute()) {
    echo json_encode(['message' => 'Telefone alterado com sucesso']);
} else {
    echo json_encode(['error' => 'Erro ao alterar telefone']);
    http_response_code(500);
}
 
$stmt->close();
$conn->close();

require('return.php');
?>