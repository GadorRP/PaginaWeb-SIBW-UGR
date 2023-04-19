/*Obtenemos el boton de comentarios y la seccion*/ 
const boton = document.getElementById("boton-comentario");
const SeccionComentarios = document.getElementById("SeccionComents")

/*Obtenemos el formulario, el contenedor de los comentarios y el boton de envio*/ 
const formulario = document.getElementById("formulario");
const contenedorComentarios = document.getElementById("OtrosComentarios");
const envio = document.getElementById("boton-enviar");

/* Obtenemos los diferentes campos del formulario */
const comentarioWeb = document.getElementById("comentario");
const nombreWeb = document.getElementById("lineaNombre");
const correoWeb = document.getElementById("lineaCorreo");


 /*---------------Desplegar seccion comentarios---------------*/ 
function modificar() {
    if (SeccionComentarios.style.right == "0px") /*Cuanto esta desplegado */
        SeccionComentarios.style.right = "-600px"; /*Lo escondemos a un lado (lo situamos mas alla de su propio ancho)*/
    else {
        SeccionComentarios.style.right = "0px";
    }
}

boton.addEventListener("click",modificar);

/*---------------Borrar contenido con el botón limpiar---------------*/

var limpiar = document.getElementById("borrador");
  limpiar.addEventListener("click", () => {
  comentarioWeb.value = "";
});


/*---------------Funcion para comprobar que es un formato de email válido---------------*/

function validarEmail() {
  if (!correoWeb.checkValidity()) {
    alert("Introduzca un email válido");
    return 1;
  }
}

/*---------------Funcion para comprobar que todos los campos han sido rellenados---------------*/

function validarCampos() {
  if (nombreWeb.value == "" || correoWeb.value == "" || comentarioWeb.value == ""){
    alert("Por favor rellene todos los campos antes de enviar");
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

  return dia + "/"  + mes + "/" + anio + " a las " + hora + ":" + minutos + ":" + segundos;
}


let numeroComentario = 0; //sera utilizado para identificar cada uno de los nuevos comentarios

/*---------------Agregar un comentario a la caja de comentarios---------------*/

function agregarComentario(valorNombre, contenidoComment, fechaYHora) {

  /*Creamos un nuevo comentario de tipo div y la asignamos su clase*/ 
  const nuevoComentario = document.createElement("div");
  nuevoComentario.className = "Comment-anterior";

  /*Para que al añadir un nuevo comentario se haga scroll identificamos el nuevo comentario*/ 
  nuevoComentario.setAttribute("id", "comentarioNuevo");

  /*Creamos los diferentes elementos del comentario y le asignamos
    los valores introducidos por el usuario así como su clase*/ 
  var nombre = document.createElement("h3");
  nombre.innerText = valorNombre;
  nombre.className = "titulo-comentario";

  /*Para obtener la hora llamamos a la funcion antes creada */
  var fecha = document.createElement("p");
  fecha.textContent = fechaYHora;
  fecha.className = "titulo-comentario";

  var comentario = document.createElement("p");
  comentario.innerText = contenidoComment;
  comentario.className = "texto-comentario";
  
  /*Añadimos los elementos al nuevo comentario y este a su vez al 
    contenedor de comentarios*/ 
  nuevoComentario.appendChild(nombre);
  nuevoComentario.appendChild(fecha);
  nuevoComentario.appendChild(comentario);

  contenedorComentarios.appendChild(nuevoComentario);

  /*Hacemos scroll al nuevo comentario*/
  const ultimoComentario = document.getElementById("comentarioNuevo");
  ultimoComentario.scrollIntoView({ behavior: "smooth" });

  /*Borramos los valores del formulario ya introducidos*/ 
  formulario.reset()
}

function enviarComentario() {
  
  /*Comprobamos si si todos los campos han sido rellenados y es una direccion valida de correo valida*/
  if (validarCampos() == 1 || validarEmail() == 1){
    return 1;
  }

  const formData = new FormData(formulario); // Crea un objeto FormData con los datos del formulario

  //obtengo los datos del formulario y los añado
  const nombre = nombreWeb.value;
  const comentario = comentarioWeb.value;
  const correo = correoWeb.value;

  formData.append("lineanombre", nombre);
  formData.append("lineacorreo", correo);
  formData.append("comentario", comentario);

  //obtengo la fecha y la hora y la añado al formulario
  const fechaYHora = obtenerHoraActual();
  formData.append("fechaYHora", fechaYHora);

  //obtengo el id del cientifico
  var id = document.getElementById("id_cientifico").dataset.id;
  formData.append("idCientifico", id);
  
  // Envío los datos mediante una petición POST a mi archivo PHP
  fetch("formulario.php", {
    method: "POST",
    body: formData
  })
  .then(response => response.json())
  .catch(error => {
    console.error(error);
  });

    agregarComentario(nombre,comentario,fechaYHora);

}


envio.addEventListener("click",enviarComentario);


/*---------------Censurar lista de palabras---------------*/

//obtener palabras censuradas
const palabrasCensuradas = [];

//pido al archivo javascript el array de palabras
fetch('formulario.php?accion=obtenerArray')
  .then(response => response.json())
  .then(data => {

    for (let i in data) {
      palabrasCensuradas.push(data[i].palabra);
    }
})
  .catch(error => {
    console.error(error);
});

comentarioWeb.addEventListener('input', function() {
  let texto = this.value; //obtengo el texto introducido
  
  palabrasCensuradas.forEach(palabra => { /*Itero por cada palabra del array de censuradas*/
  
    const regex = new RegExp("\\b" + palabra + "\\b", 'gi');  /*Busco la palabra con limites al principio y al final*/
                                                              /*g: buscar en todas las palabras censuradas, i no distinguir entre mayusculas y minusculas*/
    texto = texto.replace(regex, '*'.repeat(palabra.length)); /*busco en el texto la expresion regular y la reemplazo*/
  });
  
  this.value = texto; /*Asigno el nuevo texto*/
});













