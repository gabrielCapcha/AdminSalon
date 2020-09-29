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
        var tableName = document.getElementById('tableName');
        var tableDescription = document.getElementById('tableDescription');
        var tableCode = document.getElementById('tableCode');
        var tableReservationCode = document.getElementById('tableReservationCode');
        var tableWarehouse = document.getElementById('tableWarehouse');
        var tableFloor = document.getElementById('tableFloor');
        var tableMaxCapacity = document.getElementById('tableMaxCapacity');
        var button = document.getElementById('button');
        var validation = 0;

        if (!tableName.checkValidity()) {
            tableName.style.borderColor = 'red';
            validation++;
        }
        if (!tableDescription.checkValidity()) {
            tableDescription.style.borderColor = 'red';
            validation++;
        }
        if (!tableCode.checkValidity()) {
            tableCode.style.borderColor = 'red';
            validation++;
        }
        if (!tableReservationCode.checkValidity()) {
            tableReservationCode.style.borderColor = 'red';
            validation++;
        }
        if (!tableWarehouse.checkValidity()) {
            tableWarehouse.style.borderColor = 'red';
            validation++;
        }
        if (!tableFloor.checkValidity()) {
            tableFloor.style.borderColor = 'red';
            validation++;
        }
        if (!tableMaxCapacity.checkValidity()) {
            tableMaxCapacity.style.borderColor = 'red';
            validation++;
        }
        if (!button.checkValidity()) {
            button.style.borderColor = 'red';
            validation++;
        }

        if (validation == 0) {
            button.disabled = true;
            document.getElementById("form").submit();    
        }
    }
</script>