<?php
header('Content-Type: application/json');
require('database.php'); // Inclua aqui a sua conexão com o banco de dados usando PDO

$metodo = strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo === 'PUT') {
    // Obter e decodificar JSON do corpo da requisição
    $data = json_decode(file_get_contents('php://input'), true);

    // Verificar se json_decode conseguiu decodificar o JSON
    if ($data === null) {
        echo json_encode(['error' => 'Erro ao decodificar JSON']);
        http_response_code(400);
        exit;
    }

    // Verificar se todos os dados necessários estão presentes
    if (!isset($data['id']) || !isset($data['nome']) || !isset($data['endereco'])) {
        echo json_encode(['error' => 'Dados insuficientes']);
        http_response_code(400);
        exit;
    }

    $id = filter_var($data['id'], FILTER_VALIDATE_INT);
    $nome = filter_var($data['nome'], FILTER_SANITIZE_STRING);
    $endereco = filter_var($data['endereco'], FILTER_SANITIZE_STRING);

    if ($id === false || empty($nome) || empty($endereco)) {
        echo json_encode(['error' => 'Parâmetros nulos ou inválidos']);
        http_response_code(400);
        exit;
    }

    try {
        // Preparar a consulta para atualizar os dados da pessoa
        $query = "UPDATE pessoas SET nome = :nome, endereco = :endereco WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':endereco', $endereco, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Pessoa alterada com sucesso']);
        } else {
            echo json_encode(['error' => 'Erro ao alterar pessoa']);
            http_response_code(500);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Erro na consulta: ' . $e->getMessage()]);
        http_response_code(500);
    }
} else {
    echo json_encode(['error' => 'Método inválido - apenas PUT é permitido']);
    http_response_code(405);
}

$pdo = null; // Fechar a conexão com o banco de dados

require('return.php');
?>


