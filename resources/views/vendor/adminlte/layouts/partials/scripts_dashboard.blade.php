<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/plugins/jQuery/jquery-2.2.3.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/chartjs/Chart.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};


    $(document).ready(function() {
        var jsonResponse = document.getElementById('jsonResponse');
        var jsonResponse_ = {};
        exchangeRate = function () {
            if (jsonResponse != null) {
                jsonResponse_ = JSON.parse(jsonResponse.value);
                if (jsonResponse_.exchangeRate == null) {
                    var currencyName = 'DÓLARES';
                    switch (jsonResponse_.exchangeCurrency) {
                        case 'USD':
                            currencyName = 'DÓLARES';
                            break;
                        case 'PEN':
                            currencyName = 'SOLES';
                            break;                    
                        default:
                            currencyName = 'DÓLARES';
                            break;
                    }
                    document.getElementById('currency').value = currencyName;
                    $('#exchangeRateModal').modal({ backdrop: 'static', keyboard: false });
                    // JSON SUNAT EXCHANGE
                    $.ajax({
                        url: "/api/sunat-type-change",
                        context: document.body,
                        statusCode: {
                            500: function() {
                                document.getElementById('exchangeRateAmount').readOnly = false;
                                document.getElementById('btnSaveExchangeRate').innerHTML = 'GUARDAR';
                            }
                        }
                    }).done(function(response) {
                        if (response.status_id != undefined && response.status_id == 1) {
                            if (response.rate_venta != undefined) {    
                                document.getElementById('exchangeRateAmount').value = response.rate_venta;
                                document.getElementById('exchangeRateAmount').readOnly = false;
                            } else {
                                document.getElementById('exchangeRateAmount').value = response.holiday_venta;
                                document.getElementById('exchangeRateAmount').readOnly = false;
                            }
                        }
                        document.getElementById('btnSaveExchangeRate').innerHTML = 'GUARDAR';
                    });
                }
            }
        }
        saveExchangeRate = function () {
            $('#exchangeRateModal').modal('toggle');
            // SAVE EXCHANGE RATE
            $.ajax({
                method: "POST",
                url: "/api/exchange-rate",
                context: document.body,
                data: {
                    currency: jsonResponse_.currency,
                    amount: document.getElementById('exchangeRateAmount').value
                },
                statusCode: {
                    400: function() {
                        alert("Hubo un error en el registro. Comuníquese con soporte.");
                    }
                }
            }).done(function(response) {

            });
        }
        exchangeRate();
    });
</script>

<!-- <script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script> -->
