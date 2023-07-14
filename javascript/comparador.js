

import {creaNodo,cambioColor,cuadriculaDatos} from "./funciones.js";

var main = document.querySelectorAll("main")[0];
var fila = document.getElementById("fila");
var fila2 = document.getElementById("fila2");

/**
 * La función crea y completa un diseño de tarjeta con información de un objeto JSON y genera una
 * ventana modal con detalles adicionales y un botón de compra para cada tarjeta.
 * @param json - Un objeto JSON que contiene información sobre los automóviles que se mostrarán.
 */
function creaContenido(json, padre) {

  for (let i of json) {

    let columna = creaNodo("div", "col");
    padre.appendChild(columna);

    let card = creaNodo("div", "card");
        columna.appendChild(card);

        let imagen = creaNodo("img", "card-img-top");

        if (i.foto != "")
            imagen.src = "/imagenes/nuevos/" + i.foto;
        else
            imagen.src = "/imagenes/nuevos/base.jpg";

        card.appendChild(imagen);

        let cuerpo = creaNodo("div", "card-body");
        card.appendChild(cuerpo);

        let nombre = creaNodo("h5", "card-title");
        let textoNombre = document.createTextNode((i.fabricante).toUpperCase() + " " + (i.nombre).toUpperCase())
        nombre.appendChild(textoNombre);
        cuerpo.appendChild(nombre);

        let texto = creaNodo("p", "card-text");
        texto.style.textAlign = "center"
        let textoTexto = document.createTextNode((new Date(i.fecha_fab)).toLocaleDateString('es') + " | " + i.km + " km | " + i.desc_combustible);
        texto.appendChild(textoTexto);
        cuerpo.appendChild(texto);

        let tachado = creaNodo("div", "tachado");
        card.appendChild(tachado);

        if (i.oferta != 0) {

            let precioOferta = creaNodo("h3");
            let textoPrecioOferta = document.createTextNode(i.precio_oferta + "€");
            precioOferta.appendChild(textoPrecioOferta);
            tachado.appendChild(precioOferta);

            let precio = creaNodo("h5");
            let textoPrecio = document.createTextNode(i.precio_total + "€");
            precio.appendChild(textoPrecio);
            tachado.appendChild(precio);

            precio.style.textDecoration = "line-through";
        }
        else {
            let precio = creaNodo("h3");
            let textoPrecio = document.createTextNode(i.precio_total + "€");
            precio.appendChild(textoPrecio);
            tachado.appendChild(precio);
        }

        let pie = creaNodo("div", "card-footer");
        card.appendChild(pie);


        let boton = creaNodo("button", "btn btn-primary", "bVerMas");
        boton.setAttribute("data-bs-toggle", "modal");
        boton.setAttribute("data-bs-target", "#modalId")

        let textoBoton = document.createTextNode("Ver más")
        boton.appendChild(textoBoton);
        pie.appendChild(boton);

        boton.onclick = function () {

            let dialogo = document.getElementById("dialogo");

            let contenido = creaNodo("div", "modal-content", "contenido");
            dialogo.appendChild(contenido);

            // Modal header

            let header = creaNodo("div", "modal-header", "header");
            contenido.appendChild(header);

            let titulo = creaNodo("h5", "modal-title");
            let textoTitulo = document.createTextNode((i.fabricante).toUpperCase() + " " + (i.nombre).toUpperCase());
            titulo.appendChild(textoTitulo);
            header.appendChild(titulo);

            let close = creaNodo("button", "btn-close");
            close.setAttribute("data-bs-dismiss", "modal");
            header.appendChild(close);

            close.onclick = function () {
                for (let i of dialogo.children) {

                    i.remove();

                }
            }

            // Modal body

            let body = creaNodo("div", "modal-body", "body");
            contenido.appendChild(body);

            let row = creaNodo("div", "row", "rowPrincipal");
            body.appendChild(row);

            // Col 1

            let col = creaNodo("div", "col-6");
            row.appendChild(col);

            let fotoCoche = creaNodo("img", "w-100");

            if (i.foto != "")
                fotoCoche.src = "/imagenes/nuevos/" + i.foto;
            else
                fotoCoche.src = "/imagenes/nuevos/base.jpg";

            col.appendChild(fotoCoche);

            // Col 2

            let col2 = creaNodo("div", "col-6");
            row.appendChild(col2);

            let row1Col2 = creaNodo("div", "row");
            col2.appendChild(row1Col2);

            cuadriculaDatos(row1Col2, "Categoría", i.desc_categoria);
            cuadriculaDatos(row1Col2, "Fabricación", i.fecha_fab);
            cuadriculaDatos(row1Col2, "Kilómetros", i.km);

            cuadriculaDatos(row1Col2, "Combustible", i.desc_combustible);
            cuadriculaDatos(row1Col2, "Cambio", i.caja_cambios);
            cuadriculaDatos(row1Col2, "Motor", i.potencia);

            cuadriculaDatos(row1Col2, "Color", i.desc_color);
            cuadriculaDatos(row1Col2, "NºPuertas", i.num_puertas);
            cuadriculaDatos(row1Col2, "NºPlazas", i.num_plazas);




            // Modal footer


            let footer = creaNodo("div", "modal-footer");
            contenido.appendChild(footer);


            if (i.oferta == 0) {
                let precioCoche = creaNodo("h3");
                let textoPrecioCoche = document.createTextNode(i.precio_total)
                precioCoche.appendChild(textoPrecioCoche);
                footer.appendChild(precioCoche);
            }
            else {
                let precioCoche2 = creaNodo("h3");
                let textoPrecioCoche2 = document.createTextNode(i.precio_oferta + "€")
                precioCoche2.appendChild(textoPrecioCoche2);
                footer.appendChild(precioCoche2);
            }

            let urlPDF = creaNodo("a");
            urlPDF.href = "/coches/Informe?cod_coche=" + i.cod_coche;
            urlPDF.target = "_blanc";
            let pdf = creaNodo("input", "btn btn-danger", "bPDF", "button", "bPDF");
            pdf.value = "Ficha Técnica";
            urlPDF.appendChild(pdf);
            footer.appendChild(urlPDF);

            if (i.unidades > 0) {
              let bComprar = creaNodo("input", "btn btn-primary", "bComprar", "button", "bComprar");
              bComprar.value = "Comprar";
              footer.appendChild(bComprar);
              bComprar.disabled = false;
          }
          else {
              let bComprar = creaNodo("input", "btn btn-danger", "bComprar", "button", "bComprar");
              bComprar.value = "Agotado";
              footer.appendChild(bComprar);
              bComprar.disabled = true;
          }

            bComprar.onclick = function () {
                $.ajax({
                    url: '/coches/Comprar',
                    data: "cod_coche=" + i.cod_coche + "&importe_base=" + i.precio_base + "&importe_iva=" + i.precio_iva + "&importe_total=" + i.precio_total + "&unidades=" + i.unidades,
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

    let modal = creaNodo("div", "modal fade", "modalId");
    modal.setAttribute("data-bs-backdrop", "static");
    main.appendChild(modal);

    let dialogo = creaNodo("div", "modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered", "dialogo");
    modal.appendChild(dialogo);

}

/**
 * La función "limpiarMain" elimina todos los elementos secundarios de un elemento principal dado.
 */
function limpiarMain(padre) {

  if (document.querySelectorAll("#" + padre.id + " .col")[0]) {
    document.querySelectorAll("#" + padre.id + " .col")[0].remove();
  }

}



// Listas del comparador

var selectPrimero = document.getElementById("primero");
var selectPrimeroValue = selectPrimero.options[selectPrimero.selectedIndex].value;

var selectSegundo = document.getElementById("segundo");
var selectSegundoValue = selectSegundo.options[selectSegundo.selectedIndex].value;

var keys = ["fabricante", "nombre", "desc_categoria", "fecha_fab", "km",
  "desc_combustible", "caja_cambios", "potencia", "desc_color", "num_puertas",
  "num_plazas", "precio_total"];


// Muestra datos del primer coche

document.getElementById("primero").onchange = function (e) {

  e.preventDefault();

  var datos = "selectValue=" + selectPrimero.options[selectPrimero.selectedIndex].value;

  $.ajax({
    url: '/comparador/Mostrar',
    data: datos,
    type: 'POST',
    dataType: 'json',

    success: function (resp) {


      limpiarMain(fila);

      creaContenido(resp, fila);


      let coches1 = document.querySelectorAll(".coche1");

      for (let i = 0; i < keys.length; i++) {

        coches1[i].textContent = "";

      }

      document.getElementById("tituloComparador1").textContent = selectPrimero.options[selectPrimero.selectedIndex].value;

      for (let i of resp) {

        document.getElementById("tituloComparador1").textContent = i.fabricante + " " + i.nombre;
        i.fecha_fab = new Date(i.fecha_fab).toLocaleDateString();
        i.potencia += " C.V.";
        i.km += " Km";

        if(i.oferta > 0){
          i.precio_total = i.precio_oferta+" €";
        }
        else{
          i.precio_total = i.precio_total+" €";
        }

        for (let j of keys) {

          let texto = document.createTextNode(i[j]);
          document.querySelector(".coche1#" + j).appendChild(texto);

        }

      }


    },
    error: function (xhr, status) {
      alert("Error");
    }
  });
}

// Muestra datos del segundo coche

document.getElementById("segundo").onchange = function (e) {

  e.preventDefault();

  var datos = "selectValue=" + selectSegundo.options[selectSegundo.selectedIndex].value;

  $.ajax({
    url: '/comparador/Mostrar',
    data: datos,
    type: 'POST',
    dataType: 'json',

    success: function (resp) {


      limpiarMain(fila2);

      creaContenido(resp, fila2);

      let coches2 = document.querySelectorAll(".coche2");

      for (let i = 0; i < keys.length; i++) {

        coches2[i].textContent = "";

      }

      for (let i of resp) {

        document.getElementById("tituloComparador2").textContent = i.fabricante + " " + i.nombre;

        i.fecha_fab = new Date(i.fecha_fab).toLocaleDateString();
        i.potencia += " C.V.";
        i.km += " Km";
        i.precio_total += " €";

        for (let j of keys) {

          let texto = document.createTextNode(i[j]);
          document.querySelector(".coche2#" + j).appendChild(texto);

        }

      }

    },
    error: function (xhr, status) {
      alert("Error");
    }
  });
}




/* AJAX para rellenar los select */

$.ajax({
  url: '/comparador/Cargar',
  data: "",
  type: 'GET',
  dataType: 'json',

  success: function (resp) {

    for (let i of resp) {

      let option = creaNodo("option");
      let textoOption = document.createTextNode(i.fabricante + " " + i.nombre);
      option.appendChild(textoOption);
      option.value = i.cod_coche;
      selectPrimero.appendChild(option);


    }

    for (let i of resp) {

      let option = creaNodo("option");
      let textoOption = document.createTextNode(i.fabricante + " " + i.nombre);
      option.appendChild(textoOption);
      option.value = i.cod_coche;
      selectSegundo.appendChild(option);


    }

  },
  error: function (xhr, status) {
    alert("Error");
  }
});

/* El código posterior usa la función setInterval para verificar continuamente si el primer o el segundo
elemento de selección tiene un valor de 0. Si cualquiera de los elementos de selección tiene un
valor de 0, entonces el botón "bComparar" está deshabilitado. Si ambos elementos seleccionados
tienen un valor distinto de 0, entonces el botón "bComparar" está habilitado. */

setInterval(function () {

  if (selectPrimero.options[selectPrimero.selectedIndex].value == 0 || selectSegundo.options[selectSegundo.selectedIndex].value == 0) {

    document.getElementById("bComparar").disabled = true;
  }
  else {
    document.getElementById("bComparar").disabled = false;
  }

  cambioColor();

}, 100)













