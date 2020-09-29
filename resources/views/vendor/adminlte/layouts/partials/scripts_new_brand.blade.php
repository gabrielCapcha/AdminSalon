<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        formValidation = function() {
            var name_ = document.getElementById('brandName');
            name_.style.borderColor = '#ccc';
            var validation = true;
            if (!name_.checkValidity()) {
                name_.style.borderColor = "red";
                validation = false;
            }
            var code_ = document.getElementById('brandCode');
            code_.style.borderColor = '#ccc';
            var validation = true;
            if (!code_.checkValidity()) {
                code_.style.borderColor = "red";
                validation = false;
            }
            if (validation) {
                var button = document.getElementById('button');
                button.disabled = true;
                $.ajax({
                    method: "POST",
                    url: "/api/brands",
                    context: document.body,
                    data: {
                        'name': name_.value,
                        'code': code_.value
                    },
                    statusCode: {
                        500: function() {
                            button.disabled = false;
                            alert('No se pudo registrar la marca. Verifique la información ingresada e inténtelo nuevamente.');
                        },
                        403: function() {
                            button.disabled = false;
                            alert('No se pudo registrar la marca. Verifique la información ingresada e inténtelo nuevamente.');
                        },
                        400: function() {
                            button.disabled = false;
                            alert('No se pudo registrar la marca. Verifique la información ingresada e inténtelo nuevamente.');
                        },
                    }
                }).done(function(response) {
                    data = {};
                    location = "/brands";
                });
            }
        }
    });
</script>
