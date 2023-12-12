document.addEventListener('DOMContentLoaded', function () {
    // Realiza una solicitud AJAX para obtener el contador desde el servidor
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const contador = xhr.responseText;
            // Muestra el contador en el elemento con el id "contador"
            document.getElementById('contador').innerText = `Número de visitas: ${contador}`;
        }
    };
    xhr.open('GET', '../contador_visitas/contador.php', true); // Cambiado a contador.php
    xhr.send();
});
    