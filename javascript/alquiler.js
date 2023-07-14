

/**
 * Esta función crea un nuevo elemento HTML y lo devuelve.
 * @param elemento - el tipo de elemento que desea crear.
 * @param [clase] - la clase del elemento
 * @param [id] - la identificación del elemento
 * @param [tipo] - text,number,radio...
 * @param [name] - El nombre del elemento.
 * @returns el elemento que fue creado.
 */
function creaNodo(elemento, clase = "", id = "", tipo = "", name = "") {

  let elem = document.createElement(elemento);

  if (clase != "") {
    elem.className = clase;
  }

  if (id != "") {
    elem.id = id;
  }

  if (tipo != "") {
    elem.type = tipo;
  }

  if (name != "") {
    elem.name = name;
  }


  return elem;
}

/**
 * La función crea y completa un diseño de tarjeta con información de un objeto JSON y genera una
 * ventana modal con detalles adicionales y un botón de compra para cada tarjeta.
 * @param json - Un objeto JSON que contiene información sobre los automóviles que se mostrarán.
 */
function creaContenido(json) {

  for (let i of json) {

    let columna = creaNodo("div", "col");
    fila.appendChild(columna);

    let card = creaNodo("div", "card");
    columna.appendChild(card);

    let imagen = creaNodo("img", "card-img-top");

    if (i.foto != "")
      imagen.src = "/imagenes/alquiler/" + i.foto;
    else
      imagen.src = "/imagenes/alquiler/base.jpg";

    card.appendChild(imagen);

    let cuerpo = creaNodo("div", "card-body");
    card.appendChild(cuerpo);

    let nombre = creaNodo("h5", "card-title");
    let textoNombre = document.createTextNode((i.fabricante).toUpperCase() + " " + (i.nombre).toUpperCase())
    nombre.appendChild(textoNombre);
    cuerpo.appendChild(nombre);

    let texto = creaNodo("p", "card-text");
    texto.style.textAlign = "center"
    let textoTexto = document.createTextNode(((new Date(i.fecha_inicio)).toLocaleDateString('es')) + " - " + ((new Date(i.fecha_fin)).toLocaleDateString('es')) + " | " + i.num_plazas + " plazas");
    texto.appendChild(textoTexto);
    cuerpo.appendChild(texto);

    let pie = creaNodo("div");
    pie.className = "d-flex justify-content-around mb-5";
    card.appendChild(pie);

    let precio = creaNodo("h3");
    let textoPrecio = document.createTextNode(i.precio + " €");
    precio.appendChild(textoPrecio);
    pie.appendChild(precio);

    let boton = creaNodo("button", "btn btn-primary");
    let textoBoton = document.createTextNode("Alquilar")
    boton.appendChild(textoBoton);
    pie.appendChild(boton);

    if(i.borrado == 1)
      boton.disabled = true;
    else
      boton.disabled = false;

    boton.onclick = function () {
      $.ajax({
        url: '/alquilerCoches/Alquilar',
        data: "cod_alquiler=" + i.cod_alquiler + "&importe=" + i.precio,
        type: 'POST',
        dataType: 'text',

        success: function (resp) {

          location.reload();

        },
        error: function (xhr, status) {
          alert("Error de compra");
        }
      });
    }

  }

}

/**
 * La función "limpiarMain" elimina todos los elementos secundarios de un elemento principal dado.
 */
function limpiarMain() {

  let hijos = Array.from(fila.children);

  if (fila.hasChildNodes()) {
    for (let i in hijos) {
      fila.removeChild(hijos[i]);
    }
  }

}

// Filtrado 

let slideValue = document.querySelectorAll(".filtrado span")[0];
let inputSlider = document.querySelectorAll(".inputRange")[0];

inputSlider.oninput = (() => {
  slideValue.textContent = inputSlider.value;
});


document.getElementById("bFiltrar").onclick = function (e) {

  e.preventDefault();

  let categoria = document.getElementById("categoria").value;
  let precio = document.getElementById("precio").value;
  let fechaInicio = document.getElementById("fechaInicio").value;
  let fechaFin = document.getElementById("fechaFin").value;
  let plazas = document.getElementById("plazas").value;

  var datos = "categoria=" +categoria + "&precio=" + precio + "&fecha_inicio=" + fechaInicio + "&fecha_fin=" + fechaFin + "&plazas=" + plazas;

  $.ajax({
    url: '/alquilerCoches/Mostrar',
    data: datos,
    type: 'POST',
    dataType: 'json',

    success: function (resp) {

      limpiarMain();

      creaContenido(resp);

    },
    error: function (xhr, status) {
      alert("Error");
    }
  });
}


// Contenido

var main = document.querySelectorAll("main")[0];
var fila = document.getElementById("fila");

$.ajax({
  url: '/alquilerCoches/Mostrar',
  data: "",
  type: 'GET',
  dataType: 'json',

  success: function (json) {

    limpiarMain();

    creaContenido(json);


  },
  error: function (xhr, status) {
    alert('Error');
  }

});



