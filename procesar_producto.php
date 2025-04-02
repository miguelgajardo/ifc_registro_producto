<?php
require_once __DIR__ . '/includes/database.php';
header('Content-Type: application/json');
try {
    $db = Database::getInstance();
    $db->beginTransaction();
    $stmt = $db->prepare("
        INSERT INTO tbl_productos (
            codigo_producto, nombre_producto, id_bodega,
            id_sucursal, codigo_moneda, precio_producto,
            descripcion_producto
        ) VALUES (
            :codigo, :nombre, :bodega, :sucursal,
            :moneda, :precio, :descripcion
        )
    ");
    $stmt->execute([
        ':codigo' => $_POST['codigo_producto'],
        ':nombre' => $_POST['nombre_producto'],
        ':bodega' => $_POST['id_bodega'],
        ':sucursal' => $_POST['id_sucursal'],
        ':moneda' => $_POST['codigo_iso'],
        ':precio' => $_POST['precio_producto'],
        ':descripcion' => $_POST['descripcion_producto']
    ]);
    $productId = $db->lastInsertId();

    $stmt = $db->prepare("
    INSERT INTO tbl_productos_materiales (
        codigo_producto, material
    ) VALUES (
        :codigo_producto, :material
    )
");

    $materiales = json_decode($_POST['material']);
    foreach ($materiales as $material) {
        $stmt->execute([
            ':codigo_producto' => $_POST['codigo_producto'],
            ':material' => $material
        ]);
    }
    $db->commit();
    echo json_encode([
        'success' => true,
        'message' => 'Producto registrado exitosamente',
        'productId' => $productId
    ]);
} catch (PDOException $e) {
    $db->rollBack();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error de base de datos: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error Interno: ' . $e->getMessage()
    ]);
}
