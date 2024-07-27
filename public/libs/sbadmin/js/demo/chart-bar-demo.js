$(document).ready(function() {
  // Bar Chart Example
  var ctx = document.getElementById("myBarChart");
  var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["January", "February", "March", "April", "May", "June"],
      datasets: [{
        label: "Disponibilidad",
        backgroundColor: "#4e73df",
        hoverBackgroundColor: "#2e59d9",
        borderColor: "#4e73df",
        data: [], // Aquí se cargarán los datos dinámicamente
        maxBarThickness: 25 // Esto reemplaza la propiedad de los ejes
      }],
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        xAxes: [{
          time: {
            unit: 'month'
          },
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks: {
            maxTicksLimit: 6
          }
        }],
        yAxes: [{
          ticks: {
            min: 0,
            max: 100, // Ajusta el máximo según tus necesidades
            maxTicksLimit: 5,
            padding: 10,
            callback: function(value) {
              return value + '%';
            }
          },
          gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          }
        }],
      },
      legend: {
        display: false
      },
      tooltips: {
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
        callbacks: {
          label: function(tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            return datasetLabel + ': ' + tooltipItem.yLabel + '%';
          }
        }
      },
    }
  });

  // Evento para manejar la solicitud de datos cuando se hace clic en el botón
  $('#obtenerDatos').click(function() {
    // Obtener los valores de fecha y hora de los campos de entrada
    var fecha = $('#fecha').val();
    var hora = $('#hora').val();

    // Hacer la solicitud AJAX con los valores de fecha y hora
    $.ajax({
      url: '/chart-data',
      type: 'GET',
      data: {
        dia: fecha,
        hora: hora
      },
      success: function(response) {
        // Obtener el valor de disponibilidad del objeto JSON de respuesta
        var disponibilidad = parseFloat(response.disponibilidad);

        // Verificar si el valor de disponibilidad es válido
        if (!isNaN(disponibilidad)) {
          // Actualizar los datos de la gráfica de barras con el valor de disponibilidad recibido
          myBarChart.data.datasets[0].data = [disponibilidad];
          myBarChart.update();
        } else {
          console.error('Error: El valor de disponibilidad no es válido');
        }
      },
      error: function(xhr, status, error) {
        // Manejar errores si ocurren durante la solicitud AJAX
        console.error(error);
      }
    });
  });
});