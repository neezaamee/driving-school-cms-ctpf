<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Bar Chart</title>
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- jQuery (for AJAX) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Your Content Here -->
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <!-- Bar Chart -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Bar Chart</h3>
                </div>
                <div class="card-body">
                  <canvas id="enrollment-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <!-- AdminLTE JS -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
  <!-- Custom Script to Initialize the Bar Chart -->
  <script>
    $(function() {
      'use strict';

      var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      };
      var mode = 'index';
      var intersect = true;
      var $salesChart = $('#enrollment-chart');

      // Fetch the data from the server
      $.ajax({
        url: 'getEnrollmentData.php', // Your PHP script to get admissions data
        method: 'GET',
        success: function(data) {
          // Assuming the data contains two arrays: currentYear and previousYear
          var currentYearData = data.currentYear;
          var previousYearData = data.previousYear;

          // Update the chart with the fetched data
          var salesChart = new Chart($salesChart, {
            type: 'bar',
            data: {
              labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
              datasets: [{
                label: 'Current Year',
                backgroundColor: '#007bff',
                borderColor: '#007bff',
                data: currentYearData
              }, {
                label: 'Previous Year',
                backgroundColor: '#ced4da',
                borderColor: '#ced4da',
                data: previousYearData
              }]
            },
            options: {
              maintainAspectRatio: false,
              tooltips: {
                mode: mode,
                intersect: intersect
              },
              hover: {
                mode: mode,
                intersect: intersect
              },
              legend: {
                display: true // Show legend to distinguish between datasets
              },
              scales: {
                yAxes: [{
                  gridLines: {
                    display: true,
                    lineWidth: '4px',
                    color: 'rgba(0, 0, 0, .2)',
                    zeroLineColor: 'transparent'
                  },
                  ticks: $.extend({
                    beginAtZero: true,
                    callback: function(value) {
                      if (value >= 1000) {
                        value /= 1000;
                        value += 'k';
                      }
                      return value; // Modified to remove dollar sign
                    }
                  }, ticksStyle)
                }],
                xAxes: [{
                  display: true,
                  gridLines: {
                    display: false
                  },
                  ticks: ticksStyle
                }]
              }
            }
          });
        },
        error: function(xhr, status, error) {
          console.error('Error fetching admissions data:', error);
        }
      });
    });
  </script>
</body>

</html>