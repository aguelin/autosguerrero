
/* Crea un mapa  */

var map = L.map('map').setView([37.0304881, -4.5373355], 14.5);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {

}).addTo(map);

L.marker([37.0304881, -4.5373355]).addTo(map)
    .bindPopup('<h5><b>Autos Guerrero</b></h5> <br> C. Cueva de Viera, 2, 29200 Antequera, Málaga')
    .openPopup();