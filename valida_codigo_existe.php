<?php
/* FLUJO VALIDACIÓN CÓDIGO PRODUCTO EN BD */
require_once __DIR__ . '/includes/database.php';
header('Content-Type: application/json');
try {
    /* OBTIENE INPUT */
    $codigo = filter_input(INPUT_POST, 'codigo_producto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (empty($codigo)) {
        throw new Exception('No se ingresó un código de producto válido');
    }
    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT COUNT(*) FROM tbl_productos WHERE codigo_producto = :codigo");
    $stmt->bindParam(':codigo', $codigo);
    /* EJECUTA CONSULTA CODIGO */
    $stmt->execute();
    $count = $stmt->fetchColumn();
    /* RESPONSE */
    echo json_encode(['exists' => $count > 0]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}