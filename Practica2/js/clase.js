 /*---------------Desplegar seccion comentarios---------------*/ 
const boton = document.getElementById("boton-comentario");
const SeccionComentarios = document.getElementById("SeccionComents")

function modificar() {
    if (SeccionComentarios.style.display == "grid")
        SeccionComentarios.style.display = "none";
    else {
        SeccionComentarios.style.display = "grid";
    }
}

boton.addEventListener("click",modificar);

/*---------------Borrar contenido con el botón limpiar---------------*/

var limpiar = document.getElementById("borrador");
limpiar.addEventListener("click", () => {
  const contenidoWeb = document.getElementById("comentario").value = "";
});


/*---------------Añadir nuevo comentario a la sección de comentarios---------------*/ 

/*Obtenemos el formulario, el contenedor de los comentarios y el boton de envio*/ 
const formulario = document.getElementById("formulario");
const contenedorComentarios = document.getElementById("OtrosComentarios");
const envio = document.getElementById("boton-enviar");

/*---------------Funcion para comprobar que es un formato de email válido---------------*/

function validarEmail() {
  const correoWeb = document.getElementById("lineaCorreo");
  if (!correoWeb.checkValidity()) {
    alert("Introduzca un email válido");
    return 1;
  }
}

/*---------------Obtener la fecha y hora actual---------------*/
function obtenerHoraActual(){

  const fechaActual = new Date();
  const anio = fechaActual.getFullYear();
  const mes = fechaActual.getMonth() + 1;
  const dia = fechaActual.getDate();
  const hora = fechaActual.getHours();
  const minutos = fechaActual.getMinutes();
  const segundos = fechaActual.getSeconds();

  return "Publicado el " + dia + "/"  + mes + "/" + anio + " a las " + hora + ":" + minutos + ":" + segundos;
}

let numeroComentario = 0;

function agregarComentario() {
  /*Obtenemos los datos introducidos por el usuario */
  const nombreWeb = document.getElementById("lineaNombre").value;
  const comentarioWeb = document.getElementById("comentario").value;

  /*Comprobamos si es una direccion valida */
  if (validarEmail() == 1){
    return 1;
  }

  /*Creamos un nuevo comentario de tipo div y la asignamos su clase*/ 
  const nuevoComentario = document.createElement("div");
  nuevoComentario.className = "Comment-anterior";

  /*Para que al añadir un nuevo comentario se haga scroll identificamos el nuevo comentario*/ 
  numeroComentario++;
  nuevoComentario.setAttribute("id", "comentario-" + numeroComentario);

  /*Creamos los diferentes elementos del comentario y le asignamos
    los valores introducidos por el usuario así como su clase*/ 
  var nombre = document.createElement("h3");
  nombre.innerText = nombreWeb;
  nombre.className = "titulo-comentario";

  /*Para obtener la hora llamamos a la funcion antes creada */
  var fecha = document.createElement("p");
  const fechaYHora = obtenerHoraActual();
  fecha.textContent = fechaYHora;
  fecha.className = "titulo-comentario";

  var comentario = document.createElement("p");
  comentario.innerText = comentarioWeb;
  comentario.className = "texto-comentario";
  
  /*Añadimos los elementos al nuevo comentario y este a su vez al 
    contenedor de comentarios*/ 
  nuevoComentario.appendChild(nombre);
  nuevoComentario.appendChild(fecha);
  nuevoComentario.appendChild(comentario);

  contenedorComentarios.appendChild(nuevoComentario);

  /*Hacemos scroll al nuevo comentario*/
  const ultimoComentario = document.getElementById("comentario-" + numeroComentario);
  ultimoComentario.scrollIntoView({ behavior: "smooth" });

  /*Borramos los valores del formulario ya introducidos*/ 
  formulario.reset()
}

envio.addEventListener("click",agregarComentario);













