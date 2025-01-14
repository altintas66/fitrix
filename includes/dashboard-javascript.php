<?php 
    global $dashboard_monats_statistik, $dashboard_jahr, $user;

    if($user['theme_mode'] == 'light') $text_color = '#333';
    else $text_color = '#fff';

    $umsaetze  = array();
    $zahlungen = array();

    foreach($dashboard_monats_statistik AS $monat => $buff) {
        $rechnungsausgang = floatval($buff['rechnungsausgang'] / 1000);
        $zahlungseigang = floatval($buff['zahlungseigang'] / 1000);

        array_push($umsaetze, number_format($rechnungsausgang, 2));
        array_push($zahlungen, number_format($zahlungseigang, 2));
    }

?>
    <script>
      var textcolor = '<?php echo $text_color; ?>';
      
      var options = {
        series: [{
          name: "Umsatz",
          data:  <?php echo '[' . implode(',', $umsaetze) . ']' ?>
        }], 
        chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        stroke: {
          curve: 'straight'
        },
        grid: {
          row: {
            colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
            opacity: 1
          },
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
            labels: {
                style: {
                    colors: textcolor,
                    fontSize: '14px'
                }
            },
        },
        yaxis: {
          labels: {
            style: {
              colors: textcolor,
              fontSize: '14px'
            }
          }
        },
        tooltip: {
          theme: "dark", // Options: 'light', 'dark'
          style: {
            background: "#f4f4f4", // Custom background color
            color: "#000", // Text color
            fontSize: "12px",
            fontFamily: "Arial",
          },
          y: {
          formatter: function(value) {
            return value + ' Tsd.';
          }
        }
        }
      };

      var options2 = {
        series: [{
          name: "Zahlungen",
          data:  <?php echo '[' . implode(',', $zahlungen) . ']' ?>
        }],
        chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        stroke: {
          curve: 'straight'
        },
        grid: {
          row: {
            colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
            opacity: 1
          },
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
            labels: {
                style: {
                    colors: textcolor,
                    fontSize: '14px'
                }
            },
        },
        yaxis: {
          labels: {
            style: {
              colors: textcolor,
              fontSize: '14px'
            }
          }
        },
        tooltip: {
          theme: "dark",
          style: {
            background: "#f4f4f4", // Custom background color
            color: "#000", // Text color
            fontSize: "12px",
            fontFamily: "Arial",
          },
          
        }
      };

      var chart = new ApexCharts(document.querySelector("#chart_rechnungsausgang"), options);
      chart.render();

      var chart2 = new ApexCharts(document.querySelector("#chart_zahlungseingang"), options2);
      chart2.render();

      

    </script>