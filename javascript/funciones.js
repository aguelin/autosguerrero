export { creaNodo, creaContenido, limpiarMain, cuadriculaDatos, filtrado, formFiltrado, actualizarModelos, mostrar, cambioColor, fila };

var main = document.querySelectorAll("main")[0];
var fila = document.getElementById("fila");
var marca = document.getElementById("marca");
var modelo = document.getElementById("modelo");


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
function creaContenido(json, ctr) {

    for (let i of json) {

        let columna = creaNodo("div", "col");
        fila.appendChild(columna);

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
        let textoTexto = document.createTextNode(((new Date(i.fecha_fab)).toLocaleDateString('es')) + " | " + i.km + " km | " + i.desc_combustible);
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
            cuadriculaDatos(row1Col2, "Fabricación", (new Date(i.fecha_fab)).toLocaleDateString('es'));
            cuadriculaDatos(row1Col2, "Kilómetros", i.km + " km");

            cuadriculaDatos(row1Col2, "Combustible", i.desc_combustible);
            cuadriculaDatos(row1Col2, "Cambio", i.caja_cambios);
            cuadriculaDatos(row1Col2, "Motor", i.potencia + " C.V.");

            cuadriculaDatos(row1Col2, "Color", i.desc_color);
            cuadriculaDatos(row1Col2, "NºPuertas", i.num_puertas);
            cuadriculaDatos(row1Col2, "NºPlazas", i.num_plazas);




            // Modal footer


            let footer = creaNodo("div", "modal-footer");
            contenido.appendChild(footer);


            if (i.oferta == 0) {
                let precioCoche = creaNodo("h3");
                let textoPrecioCoche = document.createTextNode(i.precio_total + "€")
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
            urlPDF.href = "/" + ctr + "/Informe?cod_coche=" + i.cod_coche;
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
                    url: '/' + ctr + '/Comprar',
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

    let hijos = Array.from(padre.children);

    if (padre.hasChildNodes()) {
        for (let i in hijos) {
            padre.removeChild(hijos[i]);
        }
    }

}

/**
 * La función crea una cuadrícula de datos con etiquetas y valores.
 * @param fila - un elemento DOM que representa una fila en un diseño de cuadrícula
 * @param label - La etiqueta es una cadena que representa el nombre o título de los datos que se
 * muestran. Por ejemplo, si los datos que se muestran son el nombre de una persona, la etiqueta podría
 * ser "Nombre:".
 * @param value - El valor que se mostrará en el elemento creado.
 */
function cuadriculaDatos(fila, label, value) {

    let col = creaNodo("div", "col-3 m-3");
    fila.appendChild(col);
    let pCol = creaNodo("p", "pCol");

    let pCol2 = creaNodo("p")

    let textopCol = document.createTextNode(label);
    let textoCol2 = document.createTextNode(value);
    pCol.appendChild(textopCol);
    pCol2.appendChild(textoCol2);
    col.appendChild(pCol);
    col.appendChild(pCol2)

}

/**
 * Esta función filtra los datos del automóvil según la entrada del usuario y los envía al servidor
 * para su visualización.
 * @param ctr - El parámetro "ctr" es una cadena que representa el nombre del controlador para la
 * solicitud AJAX. Se utiliza para especificar la URL de la solicitud AJAX.
 */
function filtrado(ctr) {

    document.getElementById("bFiltrar").onclick = function (e) {

        e.preventDefault();

        let marca = document.getElementById("marca").value;
        let modelo = document.getElementById("modelo").value;
        let precio = document.getElementById("precio").value;
        let km = document.getElementById("km").value;
        let fechaInicio = document.getElementById("fechaInicio").value;
        let fechaFin = document.getElementById("fechaFin").value;
        let categoria = document.getElementById("categoria").value;
        let combustible = document.getElementById("combustible").value;
        let cajaCambios = document.getElementById("caja_cambios").value;
        let plazas = document.getElementById("plazas").value;
        let potencia = document.getElementById("potencia").value;

        var datos = "marca=" + marca + "&modelo=" + modelo + "&precio=" + precio + "&km=" + km + "&fecha_inicio=" + fechaInicio + "&fecha_fin=" + fechaFin +
            "&categoria=" + categoria + "&combustible=" + combustible + "&caja_cambios=" + cajaCambios + "&plazas=" + plazas + "&potencia=" + potencia;

        $.ajax({
            url: '/' + ctr + '/Mostrar',
            data: datos,
            type: 'POST',
            dataType: 'json',

            success: function (resp) {

                limpiarMain(fila);

                creaContenido(resp, "coches");

            },
            error: function (xhr, status) {
                alert("Error");
            }
        });
    }

}

/**
 * La función crea un formulario con controles deslizantes y menús desplegables para filtrar datos por
 * fecha y valores numéricos.
 */
function formFiltrado() {
    let slideValue = document.querySelectorAll(".filtrado span")[0];
    let slideValue2 = document.querySelectorAll(".filtrado span")[1];
    let slideValue3 = document.querySelectorAll(".filtrado span")[2];
    let inputSlider = document.querySelectorAll(".inputRange")[0];
    let inputSlider2 = document.querySelectorAll(".inputRange")[1];
    let inputSlider3 = document.querySelectorAll(".inputRange")[2];


    inputSlider.oninput = (() => {
        slideValue.textContent = inputSlider.value;
    });

    inputSlider2.oninput = (() => {
        slideValue2.textContent = inputSlider2.value;
    });

    inputSlider3.oninput = (() => {
        slideValue3.textContent = inputSlider3.value;
    });

    let fechaInicio = document.getElementById("fechaInicio");
    let fechaFin = document.getElementById("fechaFin");
    let añoActual = new Date().getFullYear();

    for (let i = 2000; i <= añoActual; i++) {

        let option = creaNodo("option");
        let textoOption = document.createTextNode(i);
        option.value = i;
        option.appendChild(textoOption);
        fechaInicio.appendChild(option);

    }

    for (let i = 2000; i <= añoActual; i++) {

        let option = creaNodo("option");
        let textoOption = document.createTextNode(i);
        option.value = i;

        if (i == añoActual) {
            option.selected = true;
        }

        option.appendChild(textoOption);
        fechaFin.appendChild(option);

    }
}

/**
 * Esta función actualiza una lista de modelos según la marca seleccionada utilizando AJAX.
 * @param ctr - El parámetro `ctr` es una cadena que representa el nombre del controlador que manejará
 * la solicitud AJAX.
 */
function actualizarModelos(ctr) {
    marca.onchange = function () {

        var datos = "";


        if (marca.options[marca.selectedIndex].value == "") {
            modelo.disabled = true;
            limpiarMain(modelo);
            datos = "";
        }
        else {
            modelo.disabled = false;
            datos = "marca=" + marca.options[marca.selectedIndex].value;

            $.ajax({
                url: '/' + ctr + '/ListaModelo',
                data: datos,
                type: 'POST',
                dataType: 'json',

                success: function (json) {

                    limpiarMain(modelo);

                    for (let i of json) {

                        let option = creaNodo("option");
                        option.value = i.nombre;
                        let textoOption = document.createTextNode(i.nombre);
                        option.appendChild(textoOption);
                        modelo.appendChild(option);
                    }

                },
                error: function (xhr, status) {
                    alert('Error');
                }

            });

        }


    }
}

/**
 * Esta función envía una solicitud AJAX para recuperar datos JSON y luego los usa para crear contenido
 * en una página web.
 * @param ctr - El parámetro `ctr` es una cadena que representa el nombre del controlador en el código
 * del lado del servidor. Se utiliza para construir la URL para la solicitud AJAX.
 */
function mostrar(ctr) {

    $.ajax({
        url: '/' + ctr + '/Mostrar',
        data: "",
        type: 'GET',
        dataType: 'json',

        success: function (json) {

            limpiarMain(fila);

            creaContenido(json, "coches");


        },
        error: function (xhr, status) {
            alert('Error');
        }

    });

}



/**
 * La función "cambioColor" cambia el color de ciertos elementos en función de sus valores.
 */

function cambioColor() {
    var precio1 = document.querySelector(".coche1#precio_total");
    var precio2 = document.querySelector(".coche2#precio_total");
    var km1 = document.querySelector(".coche1#km");
    var km2 = document.querySelector(".coche2#km");
    var potencia1 = document.querySelector(".coche1#potencia");
    var potencia2 = document.querySelector(".coche2#potencia");
    var fecha1 = document.querySelector(".coche1#fecha_fab");
    var fecha2 = document.querySelector(".coche2#fecha_fab");

    if (parseFloat(precio1.textContent) > parseFloat(precio2.textContent)) {
        precio1.style.color = "red";
        precio2.style.color = "green";
    }
    else if (parseFloat(precio1.textContent) < parseFloat(precio2.textContent)) {
        precio1.style.color = "green";
        precio2.style.color = "red";
    }
    else {
        precio1.style.color = "black";
        precio2.style.color = "black";
    }

    if (parseFloat(km1.textContent) > parseFloat(km2.textContent)) {
        km1.style.color = "red";
        km2.style.color = "green";
    }
    else if (parseFloat(km1.textContent) < parseFloat(km2.textContent)) {
        km1.style.color = "green";
        km2.style.color = "red";
    }
    else {
        km1.style.color = "black";
        km2.style.color = "black";
    }

    if (parseFloat(potencia1.textContent) < parseFloat(potencia2.textContent)) {
        potencia1.style.color = "red";
        potencia2.style.color = "green";
    }
    else if (parseFloat(potencia1.textContent) > parseFloat(potencia2.textContent)) {
        potencia1.style.color = "green";
        potencia2.style.color = "red";
    }
    else {
        potencia1.style.color = "black";
        potencia2.style.color = "black";
    }


    // if (fecha1.textContent < fecha2.textContent) {
    //     fecha1.style.color = "red";
    //     fecha2.style.color = "green";
    // }
    // else if(fecha1.textContent > fecha2.textContent){
    //     fecha1.style.color = "green";
    //     fecha2.style.color = "red";
    // }
    // else{
    //     fecha1.style.color = "black";
    //     fecha2.style.color = "black";
    // }
}