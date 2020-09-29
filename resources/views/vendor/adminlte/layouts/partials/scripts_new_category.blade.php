<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/select2.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/select2/i18n/es.js') }}" type="text/javascript"></script>

<script>
    //Document Ready
    var formValidation;
    $(document).ready(function() {
        var features_ = [];
        var data = {};
        //Initialize Select2 Elements
        $('.select2').select2({
            language: 'es'
        });
        formValidation = function() {
            $('#featureId option:selected').each(function() {
                var feature = {
                    "id": $(this).val(),
                    "name": $(this).text(),
                    "includeInCode": true,
                    "filterable": true,
                    "showInMobile": true
                };
                if (feature.id != "") {
                    features_.push(feature);   
                }
            });
            
            var name_ = document.getElementById('categoryName');
            name_.style.borderColor = '#ccc';
            var validation = true;
            if (!name_.checkValidity()) {
                name_.style.borderColor = "red";
                validation = false;
            }
            if (validation) {
                var button = document.getElementById('button');
                button.disabled = true;
                var warehouseId = parseInt(document.getElementById('warehouseId').value);
                data.features = features_;
                data.flagActive = true;
                data.name = name_.value.toUpperCase();
                if (warehouseId != 0) {
                    data.warehouseId = warehouseId;
                }
                $.ajax({
                    method: "POST",
                    url: "/api/categories",
                    context: document.body,
                    data: data,
                    statusCode: {
                        500: function() {
                            button.disabled = false;
                            alert('No se pudo registrar la característica. Verifique la información ingresada e inténtelo nuevamente.');
                        },
                        403: function() {
                            button.disabled = false;
                            alert('No se pudo registrar la característica. Verifique la información ingresada e inténtelo nuevamente.');
                        },
                        400: function() {
                            button.disabled = false;
                            alert('No se pudo registrar la característica. Verifique la información ingresada e inténtelo nuevamente.');
                        },
                    }
                }).done(function(response) {
                    data = {};
                    location = "/categories";
                });
            }
        }
    });
</script>
