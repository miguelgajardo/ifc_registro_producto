<?php require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/database.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Producto</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body>
    <div class="product-form-container">
        <h1>Formulario de Producto</h1>
        <form id="formularioProducto">
            <!-- Columnas de Formulario -->
            <div class="form-columns">
                <!-- Primera Columna de Formulario -->
                <div class="form-column">
                    <!-- Código Producto -->
                    <div class="form-group">
                        <label for="codigo_producto">Código</label>
                        <input type="text" id="codigo_producto" name="codigo_producto">
                    </div>
                    <div class="form-group">
                        <label for="id_bodega">Bodega</label>
                        <select id="id_bodega" name="id_bodega">
                            <option value=""></option>
                            <?php
                            $db = Database::getInstance();
                            $query = $db->query("SELECT id_bodega, nombre_bodega FROM tbl_bodegas");
                            /*ASOCIACIÓN BODEGAS*/
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['id_bodega']}'>{$row['nombre_bodega']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="codigo_iso">Moneda</label>
                        <select id="codigo_iso" name="codigo_iso">
                            <option value=""></option>
                            <?php
                            $query = $db->query("SELECT codigo_iso, nombre_moneda FROM tbl_monedas");
                            /*ASOCIACIÓN MONEDAS*/
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['codigo_iso']}'>{$row['nombre_moneda']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- Segunda Columna de Formulario -->
                <div class="form-column">
                    <!-- Nombre Producto -->
                    <div class="form-group">
                        <label for="nombre_producto">Nombre</label>
                        <input type="text" id="nombre_producto" name="nombre_producto">
                        <!-- <small>Ingresar el nombre completo del producto, asegurándose de que sea claro y descriptivo.</small> -->
                    </div>
                    <!-- Sucursal -->
                    <div class="form-group">
                        <label for="id_sucursal">Sucursal</label>
                        <select id="id_sucursal" name="id_sucursal" disabled></select>
                    </div>
                    <!-- Precio Producto -->
                    <div class="form-group">
                        <label for="precio_producto">Precio</label>
                        <input type="text" id="precio_producto" name="precio_producto">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <!-- Material del Producto -->
                <div class="materiales-group">
                    <h3>Material del Producto</h3>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="material[]" value="plastico"> Plástico</label>
                        <label><input type="checkbox" name="material[]" value="metal"> Metal</label>
                        <label><input type="checkbox" name="material[]" value="madera"> Madera</label>
                        <label><input type="checkbox" name="material[]" value="vidrio"> Vidrio</label>
                        <label><input type="checkbox" name="material[]" value="textil"> Textil</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="descripcion_producto">Descripción</label>
                <textarea id="descripcion_producto" name="descripcion_producto"></textarea>
            </div>
          <div class="submit-container">
              <button class="submit-btn" type="submit">Guardar Producto</button>
          </div>
        </form>
    </div>
    <script type="module" src="assets/js/main.js"></script>
</body>

</html>