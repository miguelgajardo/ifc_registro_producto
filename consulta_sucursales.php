<?php
require_once __DIR__ . '/includes/database.php';

header('Content-Type: application/json');

try {
    //Obtiene input de bodega
    $bodegaId = filter_input(INPUT_GET, 'bodega', FILTER_VALIDATE_INT);
    if (!$bodegaId || $bodegaId <= 0) {
        throw new InvalidArgumentException('ID de bodega no válido');
    }
    $db = Database::getInstance();

    //Sentencia de consulta sucursal
    $stmt = $db->prepare("
        SELECT id_sucursal, nombre_sucursal 
        FROM tbl_sucursales 
        WHERE id_bodega = :bodega_id
        ORDER BY nombre_sucursal
    ");
    
    $stmt->bindParam(':bodega_id', $bodegaId, PDO::PARAM_INT);
    $stmt->execute();
    $sucursales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Valida sucursales no vacío
    if (empty($sucursales)) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'No se encontraron sucursales para esta bodega'
        ]);
        exit;
    }
    //Retorna RESP Exitosa
    echo json_encode([
        'success' => true,
        'data' => $sucursales
    ]);

} catch (InvalidArgumentException $e) {
    http_response_code(400); 
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al consultar las sucursales: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error inesperado: ' . $e->getMessage()
    ]);
}
?>