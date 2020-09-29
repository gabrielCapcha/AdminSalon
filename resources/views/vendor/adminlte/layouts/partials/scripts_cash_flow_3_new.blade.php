<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
      
<script>
    function formValidation() {
        var inpObj = document.getElementById("amount");
        var button = document.getElementById("button");
        if (!inpObj.checkValidity()) {
            inpObj.style.borderColor = "red";
        } else {
            button.disabled = true;
            document.getElementById("form").submit();
        } 
    }
    $(document).ready(function() {
        //LISTENERS
        var currency = document.getElementById('currency');
        currency.addEventListener('change', function() {
            var amount = document.getElementById('amount');
            amount.readOnly = true;
            $.ajax({
                url: '/api/total-cash-amount/' + currency.value,
                context: document.body
            }).done(function(response) {
                amount.readOnly = false;
                amount.max = response;
                var pInformationAmount = document.getElementById('pInformationAmount');
                pInformationAmount.innerHTML = currency.value + ' ' + response;
            });
        });
    });
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>