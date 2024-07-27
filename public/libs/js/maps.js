// Función que inicializa el mapa
function initMap() {
  // Coordenadas del lugar que queremos mostrar en el mapa
  const coor = { lat: 19.057250362052834, lng: -98.18011522293091 };

  // Se crea un nuevo mapa y se centra en las coordenadas proporcionadas
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 4,
    center: coor,
  });

  // Se crea una ventana para mostrar la información del marcador
  const contentString =
    '<div id="content">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<center>' +
    '<h1 id="firstHeading" class="firstHeading">Centro Expositor Puebla</h1>' +
    '<img src="./images/centro.jpg" alt="Logo" width="200" heigth="200">' +
    '<div id="bodyContent">' +
    "<p><b>Centro de convenciones Puebla</b>, Ubicado en Zona de los Fuertes, Cívica 5 de Mayo, 72260 Puebla, " +
    "es sede de eventos, congresos y exposiciones " +
    "nacionales e internacionales. " +
    '<p>Visita nuestra pagina de Facebook: <a href="https://www.facebook.com/CentroExpositorPuebla">' +
    "https://www.facebook.com/CentroExpositorPuebla</a> " +
    "</div>" +
    "</div>";

  // Ventana de información del marcador
  const infowindow = new google.maps.InfoWindow({
    content: contentString,
    ariaLabel: "Ubicación",
  });

  // Crear un marcador en el mapa en las coordenadas proporcionadas
  const marker = new google.maps.Marker({
    position: coor,
    map,
    title: "Centro Expositor Puebla",
  });

  // Se agrega un evento de clic al marcador para abrir la ventana de información
  marker.addListener("click", () => {
    infowindow.open({
      anchor: marker,
      map,
    });
  });
}

// Asignar la función initMap a la ventana global para que sea accesible
window.initMap = initMap;