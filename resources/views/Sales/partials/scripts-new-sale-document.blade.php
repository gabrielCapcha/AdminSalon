<script src="{{ asset('AdminLte/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('AdminLte/js/adminlte.js') }}" type="text/javascript"></script>
<script src="{{ asset('AdminLte/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    
    $(document).ready(function() {
    var productList = JSON.parse(document.getElementById('listOfProducts').value);
    var products = [];
    var data = {};
    data.client = {};
    data.sunatInfo = {};
    data.products = [];
    data.typePayment = {};
    var typePaymentNames = {
                1 : { "name": "EFECTIVO", "type": "number", "htmlId": "cashInputValue", "selected": true, "additionalBox": false, "readOnly": false, "exchange": true },
                2 : { "name": "VISA", "type": "number", "htmlId": "visaInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                3 : { "name": "MASTERCARD", "type": "number", "htmlId": "mastercardInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                6 : { "name": "DEPÓSITO", "type": "number", "htmlId": "depositInputValue", "selected": false, "additionalBox": true, "readOnly": false, "exchange": false },
                8 : { "name": "CRÉDITO", "type": "text", "htmlId": "creditInputValue", "selected": false, "additionalBox": true, "readOnly": false, "exchange": false },
                10 : { "name": "IZIPAY", "type": "number", "htmlId": "izipayInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                12 : { "name": "GLOVO", "type": "number", "htmlId": "glovoInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                13 : { "name": "RAPPI", "type": "number", "htmlId": "rappiInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                14 : { "name": "VENDEMAS", "type": "number", "htmlId": "vendemasInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                15 : { "name": "LUKITA", "type": "number", "htmlId": "lukitaInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                16 : { "name": "YAPE", "type": "number", "htmlId": "yapeInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                17 : { "name": "TUNKI", "type": "number", "htmlId": "tunkiInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                18 : { "name": "AMERICAN EXPRESS", "type": "number", "htmlId": "americanExpressInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                19 : { "name": "PLIM", "type": "number", "htmlId": "plimInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
            };
    productList.forEach(element => {
        products[element.id] = element;
    });
    typePayments = function(id) {
            var selectedPayment = typePaymentNames[id];
            var paymentButton = document.getElementById("typePayment_" + id);
            for (let index = 1; index < 20; index++) {
                if (index != id) {
                    disableButton = document.getElementById("typePayment_" + index);
                    if (disableButton != null) {
                        disableButton.className = 'payment-' + index + '-unselected';
                    }
                }
            }
            if (data.typePayment.name == selectedPayment.name) {
                paymentButton.className = 'payment-' + id + '-unselected';
            } else {
                data.typePayment = selectedPayment;
                paymentButton.className = 'payment-' + id + '-selected';
            }
        console.log("pagos", products);
    }

    addSelectedProduct = function (id) {  
        product = products[id];
        document.getElementById('product_'+id);
        tBody = document.getElementById('saleTbody');
        var tr = document.createElement('tr');
        tr.setAttribute("id", "row_" + product.id);
        tr.setAttribute("style", "font-size:10px;");
        var trinnerHTML_ = '<td class="static-table-td" onClick="showProductDetail('+ product.id +')"><strong style="cursor:pointer;">' + product.code + '</strong></td>' +
                        '</td><td class="static-table-td">' + product.name + '</td>' + 
                        '<td class="static-table-td-input"><input type="number" onClick="this.select();" id="quantityProduct_' + product.id + '" value=' + product.quantity + '></td>' +
                        '<td class="static-table-td"><div class="input-group input-group-sm"><span class="input-group-btn">' +
                        '<button type="button" onclick="clearSelectedProduct(' + product.id + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></span></div></td>';
        tr.innerHTML = trinnerHTML_;
        tBody.insertBefore(tr, tBody.firstChild);     
        console.log("prod", id)
    }
    var documentClient = document.getElementById('search-customer');
    documentClient.addEventListener("keyup", function(event) {
    console.log(data.client.type_document);
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