
const boton = document.getElementById("boton");
const SeccionComentarios = document.getElementById("SeccionComents")

function modificar() {
    if (SeccionComentarios.style.display == "grid")
        SeccionComentarios.style.display = "none";
    else {
        SeccionComentarios.style.display = "grid";
    }
}

boton.addEventListener("click",modificar);

/*Chat GPT*/ 
const formulario = document.getElementById("formulario");
const nombreWeb = document.getElementById("lineanombre").value;
const correoWeb = document.getElementById("lineacorreo").value;
const comentarioWeb = document.getElementById("comentario").value;
const contenedorComentarios = document.getElementById("OtrosComentarios");
const envio = document.getElementById("enviar");

const comentario = {
  nombre: nombreWeb,
  email: correoWeb,
  mensaje: comentarioWeb
};

const nuevoComentario = document.createElement("div");
nuevoComentario.classList.add("comentario");
nuevoComentario.innerHTML = `
  <h3>${nombreWeb}</h3>
  <p>${correoWeb}</p>
  <p>${comentarioWeb}</p>
`;

envio.addEventListener("click", () => contenedorComentarios.appendChild(nuevoComentario ));

/* Fin de chat gpt*/







