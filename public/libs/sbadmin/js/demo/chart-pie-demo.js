var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Disponibilidad"],
    datasets: [{
      data: [], // Aquí se cargarán los datos dinámicamente
      backgroundColor: ['#4e73df'],
      hoverBackgroundColor: ['#2e59d9'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});

// Obtener los datos del servidor utilizando AJAX
$(document).ready(function() {
  // Evento para manejar la solicitud de datos cuando se hace clic en el botón
  $('#obtenerDatos').click(function() {
      // Obtener los valores de fecha y hora de los campos de entrada
      var fecha = $('#fecha').val();
      var horaInicio = $('#hora_inicio').val();
      var horaFin = $('#hora_fin').val();

      // Hacer la solicitud AJAX con los valores de fecha, hora de inicio y hora de fin
      $.ajax({
          url: '/chart-data',
          type: 'GET',
          data: {
              fecha: fecha,
              horaInicio: horaInicio,
              horaFin: horaFin
          },
          success: function(response) {
            // Verificar si la respuesta contiene datos de disponibilidad
            if (Array.isArray(response.disponibilidad) && response.disponibilidad.length > 0) {
                // Obtener el primer elemento del array (suponiendo que solo hay uno)
                var primerElemento = response.disponibilidad[0];
                
                // Obtener el valor de disponibilidad del primer elemento
                var disponibilidad = parseFloat(primerElemento.disponibilidad);

                var totalCajones = response.totalCajones;
                var cajonesOcupados = response.cajonesOcupados;

                // Actualizar los elementos HTML con la información recibida
                $('#disponibilidadNumero').text('Disponibilidad: ' + disponibilidad.toFixed(2) + '%');
                $('#totalCajones').text(totalCajones);
                $('#cajonesOcupados').text(cajonesOcupados);
        
                // Verificar si el valor de disponibilidad es válido
                if (!isNaN(disponibilidad)) {
                    // Actualizar los datos del gráfico con el valor de disponibilidad recibido
                    myPieChart.data.datasets[0].data = [disponibilidad];
                    myPieChart.update();
                } else {
                    console.error('Error: El valor de disponibilidad no es válido');
                }
            } else {
                console.error('Error: No se encontraron datos de disponibilidad en la respuesta');
            }
        },
        
          error: function(xhr, status, error) {
              // Manejar errores si ocurren durante la solicitud AJAX
              console.error(error);
          }
      });
  });
});