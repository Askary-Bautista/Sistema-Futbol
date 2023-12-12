
function abrirModal(idPartido) {
    // Cargar el contenido del formulario en la ventana modal
    var contenidoModal = document.getElementById('contenidoModal');
    contenidoModal.innerHTML = '';
    contenidoModal.innerHTML = '<iframe src="formulario_marcador.php?id_partido=' + idPartido + '" width="390px" height="300px" frameborder="0"></iframe>';

    // Obtener la ventana modal
    var miModal = document.getElementById('miModal');

    // Ajustar manualmente la posición de la ventana modal (puedes modificar estos valores)
    var topPosition = 100; // Ajusta según sea necesario
    var leftPosition = 440; // Ajusta según sea necesario

    // Aplicar la posición manual
    miModal.style.top = topPosition + 'px';
    miModal.style.left = leftPosition + 'px';

    // Mostrar la ventana modal
    miModal.style.display = 'block';

    var cerrarModalBtn = document.getElementById("cerrarModalBtn");
    // Agrega un evento de clic al botón de cerrar
    cerrarModalBtn.addEventListener("click", function () {
        // Cierra la ventana modal
        miModal.style.display = "none";
    });
}

function cerrarModal(registroExitoso) {
    // Obtener la ventana modal
    var miModal = document.getElementById('miModal');
    var btnCerrarModal = document.getElementById('cerrarModalBtn');

    // Ocultar la ventana modal y el botón de cerrar
    miModal.style.display = 'none';
    btnCerrarModal.style.display = 'none';

    // Enviar una señal a la página principal solo si el registro fue exitoso
    if (registroExitoso) {
        console.log('Registro exitoso. Enviando señal de cierre.');
        window.parent.postMessage('modalClosed', '*');
    } else {
        console.log('Registro no exitoso. No se enviará la señal de cierre.');
    }
}

// Agregar un evento al cargar la ventana modal para asegurarse de ocultar el botón de cerrar
document.addEventListener('DOMContentLoaded', function () {
    var btnCerrarModal = document.getElementById('cerrarModalBtn');
    btnCerrarModal.addEventListener("click", function () {
        // Ocultar la ventana modal y el botón de cerrar
        var miModal = document.getElementById('miModal');
        miModal.style.display = 'none';
        btnCerrarModal.style.display = 'none';
    });
});

// Verifica si todos los marcadores han sido registrados
function verificarMarcadoresRegistrados() {
    var elementosMarcadores = document.querySelectorAll('.elemento_tabla a');
    var todosRegistrados = true;

    elementosMarcadores.forEach(function(elemento) {
        if (elemento.getAttribute('data-registrado') !== 'true') {
            todosRegistrados = false;
        }
    });

    return todosRegistrados;
}

// Habilita o deshabilita el botón según el estado de los marcadores
function actualizarEstadoBoton() {
    var boton = document.getElementById('boton-general');
    boton.disabled = !verificarMarcadoresRegistrados();
}

// Llama a la función al cargar la página
window.addEventListener('load', function() {
    actualizarEstadoBoton();
});
