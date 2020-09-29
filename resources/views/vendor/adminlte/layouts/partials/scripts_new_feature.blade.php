<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<!-- Datatables -->
<script src="{{ asset('/plugins/iCheck/icheck.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script>
    //Document Ready
    var formValidation;
    $(document).ready(function() {
        var data = {};
        var count = 0;
        var features = [];
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        })
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass   : 'iradio_minimal-red'
        })
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })
        var featureTable  = $('#table').DataTable({
            "processing": false,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "serverSide": false,
            "bPaginate": false,
            "ordering": false,
            "searching": false,
            "responsive": true
        });
        formValidation = function(){
            var name_ = document.getElementById('featureName');
            name_.style.borderColor = '#ccc';
            var validation = true;
            if (!name_.checkValidity()) {
                name_.style.borderColor = "red";
                validation = false;
            }
            if (validation) {
                var button = document.getElementById('button');
                button.disabled = true;
                data.name = name_.value.toUpperCase();
                data.features = [];
                features.forEach(element => {
                    var checkbox = document.getElementById('featureCategoryIdCheckbox_' + element.count);
                    if (checkbox.checked) {
                        data.features.push({
                            'id': element.id.toUpperCase(),
                            'name': element.name.toUpperCase(),
                        });
                    }
                });
                $.ajax({
                    method: "POST",
                    url: "/api/new-features",
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
                    location = "/features";
                });
            }
        }
        //LISTENERS
        var featureCategoryName_0 = document.getElementById('featureCategoryName_0');
        featureCategoryName_0.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                var object = {};
                //VALIDATE IDS
                var featureCategoryId_0 = document.getElementById('featureCategoryId_0');
                if (featureCategoryId_0) {
                    count++;
                    object.count = count;
                    object.id = featureCategoryId_0.value;
                    object.name = featureCategoryName_0.value;
                    features.push(object);
                    //ADD OBJECT
                    var xTable = document.getElementById('featureTableBody');
                    var tr = document.createElement('tr');
                    tr.innerHTML = '<td><input id="featureCategoryIdCheckbox_' + count + '" type="checkbox" class="minimal" checked></td>' + 
                                '<td>' + object.id.toUpperCase() + '</td>' +
                                '<td>' + object.name.toUpperCase() + '</td>';
                    xTable.insertBefore(tr, xTable.firstChild);
                    featureCategoryId_0.value = "";
                    featureCategoryName_0.value = "";
                    featureCategoryId_0.focus();
                }
            }
        });
    });
</script>
