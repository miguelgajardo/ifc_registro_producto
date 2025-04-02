import { validaFormularioProducto, validarCodigoProductoUnico } from './validate.js';

document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.getElementById('formularioProducto');
    formulario.addEventListener('submit', async function(e) {
        e.preventDefault();
        const dataFormulario = new FormData(formulario);
        const materials = Array.from(document.querySelectorAll('input[name="material[]"]:checked'))
            .map(checkbox => checkbox.value);
        dataFormulario.append('material', JSON.stringify(materials));
        const validation = validaFormularioProducto(dataFormulario);
        if (!validation.valid) {
            console.log("validation", validation)
            alert(validation.message);
            return;
        }
        try {
            //INICIA EJECUCIÓN VALIDACIÓN CODIGO EN BASE DE DATOS
            const codigoExiste = await validarCodigoProductoUnico(dataFormulario.get('codigo_producto'));
            if (codigoExiste.exists) {
                alert('El código del producto ya está registrado.');
                return;
            }
            const response = await fetch('procesar_producto.php', {
                method: 'POST',
                body: dataFormulario
            });
            const result = await response.json();
            if (result.success) {
                alert(result.message);
                formulario.reset();
                document.getElementById('id_sucursal').innerHTML = '<option value=""></option>';
                document.getElementById('id_sucursal').disabled = true;
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al procesar el formulario');
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const bodegaSelect = document.getElementById('id_bodega');
    const sucursalSelect = document.getElementById('id_sucursal');
    //CARGA SUCURSALES PARA BODEGA
    bodegaSelect.addEventListener('change', function () {
        const idBodega = this.value;
        if (idBodega) {
            fetch(`consulta_sucursales.php?bodega=${idBodega}`)
                .then(response => {
                    console.log("response: ", response)
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                }).then(data => {
                    sucursalSelect.innerHTML =
                        '<option value=""></option>';
                    //CONTROL DE EXISTENCIA DE DATOS
                    if (data.success && Array.isArray(data.data)) {
                        data?.data.forEach(sucursal => {
                            const option = document.createElement('option');
                            option.value = sucursal.id_sucursal;
                            option.textContent = sucursal.nombre_sucursal;
                            sucursalSelect.appendChild(option);
                        });
                    sucursalSelect.disabled = false;
                    } else {
                console.error('Formato Inválido de Datos:', data);
                sucursalSelect.innerHTML = '<option value="">No hay sucursales disponibles</option>';
                    }
                }).catch(error => {
                     console.error('Error al cargar las sucursales:', error);
            sucursalSelect.innerHTML = '<option value="">Error al cargar sucursales</option>';
                });
        //CONTROL DE SELECT ESTABLECE VALUE EMPTY CUANDO !BODEGA
        } else {
            sucursalSelect.innerHTML = '<option value=""></option>';
            sucursalSelect.disabled = true;
        }
    });
});