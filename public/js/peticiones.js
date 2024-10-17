document.getElementById("codigo_mascota").addEventListener("keyup", getCodigos);

function getCodigos() {
    let inputCP = document.getElementById("codigo_mascota").value;
    let lista = document.getElementById("lista");

    if (inputCP.length > 0) {
        let url = "./views/consultas/general/getMascotas.php";
        let formData = new FormData();
        formData.append("codigo_mascota", inputCP);

        fetch(url, {
            method: "POST",
            body: formData,
            mode: "cors" // Default cors, no-cors, same-origin
        })
        .then(response => {
            // Verificar si la respuesta es exitosa
            if (!response.ok) {
                throw new Error(`Error en la respuesta del servidor: ${response.status}`);
            }
            return response.text(); // Obtener la respuesta como texto
        })
        .then(data => {
            lista.style.display = 'block';
            lista.innerHTML = data; // Actualiza la lista con los datos
        })
        .catch(err => {
            console.error(err); // Manejar el error
            lista.style.display = 'none'; // Ocultar la lista si hay un error
        });
    } else {
        lista.style.display = 'none'; // Ocultar la lista si el campo está vacío
    }
}

function mostrar(cp) {
    let lista = document.getElementById("lista");
    lista.style.display = 'none';
    alert("CP: " + cp);
}
