<script src="{{ asset('AdminLte/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('AdminLte/js/adminlte.js') }}" type="text/javascript"></script>
<script src="{{ asset('AdminLte/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    var data = {};
    data.client = {};
    data.sunatInfo = {};
    data = [];
    $(document).ready(function() {
    var tableProducts = $('#creditTable').DataTable();
        var __currency__ = data.currency;
        $('#tableProductsResume').DataTable({
            "scrollX": true,
            "scrollY": "250px",
            "processing": true,
            "orderCellsTop": true,
            "fixedHeader": true,
            "lengthChange": false,
            "info": false,
            "language": {
                "url": "AdminLte/js/languages/es.json"
            },
            "serverSide": false,
            "paging": true,
            'order' : [[ 0, "desc" ]],
            "ordering": true,
            "searching": false,
            "ajax": function(data, callback, settings) {
                $.get('/api/product', function(res) {
                        console.log(data)
                        callback({
                            data: res.products
                        });
                    });
            },
            "columns"    : [
                {'data': function (data) {
                    return data.code;
                }},
                {'data': function (data) {
                    return data.name;
                }},
                {'data': function (data) {
                    return parseFloat(data.price).toFixed(2);
                }}
            ],
            "destroy": true,
        });
    var documentClient = document.getElementById('search-customer');
    documentClient.addEventListener("keyup", function(event) {
    console.log(documentClient.value);
    event.preventDefault();
    if (event.keyCode === 13) {
        switch (documentClient.value.length) {
            case 8:
                data.client.type_document = 'DNI';
                data.client.document = documentClient.value;
            break;

            case 11:
                data.client.type_document = 'RUC';
                data.client.document = documentClient.value;
            break;

            default:
                data.client.type_document = 'RUC';
                data.client.document = documentClient.value;
            break;
        }
        $.ajax({
            method: "GET",
            url: "/api/customer",
            context: document.body,
            data: data.client,
            statusCode: {
                400: function() {
                    button.disabled = false;
                    alert("El número de documento no existe.");
                }
            }
        }).done(function(response) {
            alert("Cliente encontrado.");
            data.sunatInfo = response;
        });
    }
    });
    });
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>