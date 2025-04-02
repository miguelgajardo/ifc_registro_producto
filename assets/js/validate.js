//Funciones de Validación de Campos Formulario Producto
export async function validarCodigoProductoUnico(codigo) {
    try {
        const response = await fetch('valida_codigo_existe.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `codigo_producto=${encodeURIComponent(codigo)}`
        });
        if (!response.ok) throw new Error('Error Interno');
        return await response.json();
    } catch (error) {
        console.error('Error en la Validación:', error);
        throw error;
    }
}

export function validarCodigoProducto(codigo) {
    if (codigo === '') {
        return { valid: false, message: 'El código del producto no puede estar en blanco.' };
    }
    const regex = /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;
    if (!regex.test(codigo)) {
        return { valid: false, message: 'El código del producto debe contener letras y números.' };
    }
    if (codigo.length < 5 || codigo.length > 15) {
        return { valid: false, message: 'El código del producto debe tener entre 5 y 15 caracteres.' };
    }
    return { valid: true };
}

export function validarNombreProducto(nombre) {
    if (nombre === '') {
        return { valid: false, message: 'El nombre del producto no puede estar en blanco.' };
    }
    
    if (nombre.length < 2 || nombre.length > 50) {
        return { valid: false, message: 'El nombre del producto debe tener entre 2 y 50 caracteres.' };
    }
    
    return { valid: true };
}

export function validarPrecioProducto(precio) {
    if (precio === '') {
        return { valid: false, message: 'El precio del producto no puede estar en blanco.' };
    }
    const regex = /^\d+(\.\d{1,2})?$/;
    if (!regex.test(precio)) {
        return { valid: false, message: 'El precio del producto debe ser un número positivo con hasta dos decimales.' };
    }
    const valor = parseFloat(precio);
    if (valor <= 0) {
        return { valid: false, message: 'El precio del producto debe ser un número positivo con hasta dos decimales.' };
    }
    return { valid: true };
}

export function validarMaterial(materiales) {
    if (materiales.length < 2) {
        return { valid: false, message: 'Debe seleccionar al menos dos materiales para el producto.' };
    }
    return { valid: true };
}

export function validarBodega(bodega) {
    if(!bodega) {
        return { valid: false, message: 'Debe seleccionar una bodega.'}
    }
    return { valid: true };
}

export function validarSucursal(sucursal) {
    if(!sucursal) {
        return {valid: false, message: "Debe seleccionar una sucursal para la bodega seleccionada."}
    }
    return {valid: true };
}

export function validarMoneda(moneda) {
    if (!moneda) {
        return { valid: false, message: 'Debe seleccionar una moneda para el producto.' };
    }
    return { valid: true };
}

export function validarDescripcion(descripcion) {
    if (descripcion.trim() === '') {
        return { valid: false, message: 'La descripción del producto no puede estar en blanco.' };
    }
    if (descripcion.length < 10 || descripcion.length > 1000) {
        return { valid: false, message: 'La descripción del producto debe tener entre 10 y 1000 caracteres.' };
    }
    return { valid: true };
}

export function validaFormularioProducto(dataFormulario) {
    console.log("Formdata", dataFormulario);
    const validations = [
        validarCodigoProducto(dataFormulario.get('codigo_producto')),
        validarNombreProducto(dataFormulario.get('nombre_producto')),
        validarBodega(dataFormulario.get('id_bodega')),
        validarSucursal(dataFormulario.get('id_sucursal')),
        validarPrecioProducto(dataFormulario.get('precio_producto')),
        validarMoneda(dataFormulario.get('codigo_iso')),
        validarMaterial(JSON.parse(dataFormulario.get('material'))),
        validarDescripcion(dataFormulario.get('descripcion_producto'))
    ];
    
    return validations.find(result => !result.valid) || { valid: true };
}