<!-- <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script> -->
<!-- <script src="{{ asset('AdminLte/plugins/jquery/jquery-2.2.3.min.js') }}" type="text/javascript"></script> -->
<script src="{{ asset('AdminLte/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('AdminLte/js/adminlte.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    var productName = '';
    var productPrice = '';
    var productDate = '';
    var productCode = '';
    var productList = JSON.parse(document.getElementById('listOfProducts').value);
    var newProductList = [];

    productList.forEach(element => {
        newProductList[element.id] = element;
    });

    $(document).ready(function() {
        createProduct = function () {
            $('#modal-new-product').modal({ backdrop: 'static', keyboard: false });
        }
        infoProduct = function (id) {
            $('#modal-info-product').modal({ backdrop: 'static', keyboard: false });
            document.getElementById('infoProductName').value = newProductList[id].name;
            document.getElementById('infoProductPrice').value = newProductList[id].price;
            document.getElementById('infoProductCode').value = newProductList[id].code;
            document.getElementById('infoProductDate').value = newProductList[id].register_date;
        }
        createNewProduct = function () {
            productName = document.getElementById('productName').value;
            productPrice = document.getElementById('productPrice').value;
            productCode = document.getElementById('productCode').value;
            productDate = document.getElementById('productDate').value;
            var data = {
                "name" : productName,
                "price" : productPrice,
                "code" : productCode,
                "register_date" : productDate,
            }
            $.ajax({
                method: "POST",
                url: "/api/product",
                context: document.body,
                data: data,
                statusCode: {
                    400: function() {
                        button.disabled = false;
                        alert("Hubo un error en el registro. Es posible que los datos no sean los correctos.");
                    }
                }
            }).done(function(response) {
                alert("Registro exitoso.");
            });
        }
        editProductModal = function (id) {
            $('#modal-edit-product').modal({ backdrop: 'static', keyboard: false });
            document.getElementById('editProductName').value = newProductList[id].name;
            document.getElementById('editProductPrice').value = newProductList[id].price;
            document.getElementById('editProductCode').value = newProductList[id].code;
            document.getElementById('editProductDate').value = newProductList[id].register_date;
        }

        saveProduct = function (id) {
            productName = document.getElementById('productName').value;
            productPrice = document.getElementById('productPrice').value;
            productCode = document.getElementById('productCode').value;
            productDate = document.getElementById('productDate').value;
            var data = {
                "name" : productName,
                "price" : productPrice,
                "code" : productCode,
            }
            $.ajax({
                method: "PUT",
                url: "/api/product/" + id,
                context: document.body,
                data: data,
                statusCode: {
                    400: function() {
                        button.disabled = false;
                        alert("Hubo un error en el registro. Es posible que los datos no sean los correctos.");
                    }
                }
            }).done(function(response) {
                alert("Actualización exitosa.");
            });
        }
    });
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>