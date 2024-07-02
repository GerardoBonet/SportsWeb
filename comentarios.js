
const mostrarComentarios = document.getElementById("MostrarComentarios");
const comentarios = document.getElementById("Comentarios");
const comentarioNuevo = document.getElementById("comentarioNuevo");



// Mostrar o esconder comentarios al hacer clic en el botón
mostrarComentarios.addEventListener("click", function() {
    if (comentarios.style.display == "none") {
        comentarios.style.display = "block";
    } else {
        comentarios.style.display = "none";
    }
});


// Reemplazar palabras prohibidas en el texto
function reemplazarPalabras(texto) {
    

    palabrasProhibidas.forEach(function(palabra) {
        const expresionRegular = new RegExp(palabra, "gi");//Crea una expresion regular para cada palabra prohibida, con "gi" para que sean mayúsculas o minúsculas
        texto = texto.replace(expresionRegular, "*".repeat(palabra.length));//Reemplaza la palabra prohibida por asteriscos
    });
    return texto;
}

// Reemplazar palabras prohibidas en el texto del comentario
const textoInput = document.getElementById("textoComentario");
textoInput.addEventListener("input", function() {//Evento que se produce cada vez que el usuario escribe en el campo de texto
    const textoComentario = reemplazarPalabras(textoInput.value);
    textoInput.value = textoComentario; // Actualiza el valor del campo de texto con las palabras reemplazadas
});




// Manejar el envío del formulario
comentarioNuevo.addEventListener("submit", function(event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    console.log(nick);
    console.log(correo);

    const nombreInput = nick;
    const emailInput = correo;
    const textoInput = document.getElementById("textoComentario");

    
    //Combrueba que no este ningun campo vacio
    if (textoInput.value == "") {
        alert("Por favor, rellena todos los campos.");
        return;
    }
    console.log(emailInput);

    



    var  comentario = {
        email: emailInput,
        texto: textoInput.value,
        fecha: new Date().toLocaleString(),
        idAct: idEv

    };
    console.log(comentario);

    
    fetch('recibirDatos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(comentario)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Error al enviar el comentario.");
        }
        // Si la respuesta es exitosa, limpiar los campos del formulario
        nombreInput.value = "";
        emailInput.value = "";
        textoInput.value = "";
    
        console.log("Comentario enviado correctamente.");
    })
    
});

