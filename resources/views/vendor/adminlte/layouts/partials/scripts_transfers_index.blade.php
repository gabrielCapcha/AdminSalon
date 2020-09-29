<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/buttons/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.flash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.print.min.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    var values = 1;
    var toSecondState;
    var toThirdState;
    var printDocument;
    var deleteTransfer;
    var detailDocument;
    var arrayTransfers = [];
    $(document).ready(function() {
        var warehouseId = document.getElementById('warehouse_id').value;
        function callBackFunction () {
            $('#transferData').DataTable({
                "scrollX": false,
                'processing'  : true,
                // 'serverSide'  : true,
                'paging'      : true,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : true,
                'order'       : [[ 4, "desc" ]],
                "dom": 'Bfrtip',
                "buttons": [],
                'info'        : true,
                'autoWidth'   : true,
                "language": {
                    "url": "/js/languages/datatables/es.json"
                },
                "bDestroy": true,
                "ajax": function(data, callback, settings) {
                    $.get('/api/transfers', {
                        searchInput: $('#statusId').val(),
                        }, function(res) {
                            arrayTransfers = [];
                            res.forEach(element => {
                                arrayTransfers[element.id] = element;
                            });                             
                            callback({
                                recordsTotal: res.length,
                                recordsFiltered: res.length,
                                data: res
                            });
                        });
                },
                "columns"    : [
                    {'data': function(data) {
                        return data.serie + '-' + ("000000" + data.number).slice(-8);
                    }},
                    {'data': 'warehouseOriginName'},
                    {'data': 'warehouseSourceName'},
                    {'data': function (data, type, dataToSet) { 
                        var text = 'PENDIENTE';
                        switch (data.status) {
                                case 1:
                                text = 'PENDIENTE';
                                    break;
                                case 2:
                                text = 'EN TRANSCURSO';
                                    break;
                                case 3:
                                text = 'FINALIZADO';
                                    break;
                                default:
                                text = 'EN TRANSCURSO';
                                    break;
                        }
                        return text;
                    }},
                    {'data': function (data, type, dataToSet) {
                        var d = new Date(data.createdAt),
                        dformat = [
                            ("0000" + d.getFullYear()).slice(-4),
                            ("00" + (d.getMonth()+1)).slice(-2),
                            ("00" + d.getDate()).slice(-2),
                        ].join('-')+' '+
                        [
                            ("00" + d.getHours()).slice(-2),
                            ("00" + d.getMinutes()).slice(-2),
                            ("00" + d.getSeconds()).slice(-2),
                        ].join(':');

                        return dformat;
                    }},
                    {'data':  function (data, type, dataToSet) {
                        var d = new Date(data.updatedAt),
                        dformat = [
                            ("0000" + d.getFullYear()).slice(-4),
                            ("00" + (d.getMonth()+1)).slice(-2),
                            ("00" + d.getDate()).slice(-2),
                        ].join('-')+' '+
                        [
                            ("00" + d.getHours()).slice(-2),
                            ("00" + d.getMinutes()).slice(-2),
                            ("00" + d.getSeconds()).slice(-2),
                        ].join(':');

                        return dformat;
                    }},
                    {'data': function (data, type, dataToSet) {
                        if (data.cancelDate) {
                            var d = new Date(data.cancelDate),
                            dformat = [
                                ("0000" + d.getFullYear()).slice(-4),
                                ("00" + (d.getMonth()+1)).slice(-2),
                                ("00" + d.getDate()).slice(-2),
                            ].join('-')+' '+
                            [
                                ("00" + d.getHours()).slice(-2),
                                ("00" + d.getMinutes()).slice(-2),
                                ("00" + d.getSeconds()).slice(-2),
                            ].join(':');

                            return dformat;
                        } else {
                            return 'SIN ANULAR';
                        }
                    }},
                    {'data': function(data) {
                        var clearenceUser = data.clearenceUser;
                        if (clearenceUser) {
                            clearenceUser = clearenceUser.name + ' ' + clearenceUser.lastname + ' (' + clearenceUser.email + ')';
                        }
                        return clearenceUser;
                    }},
                    {'data': function(data) {
                        var cancelUser = data.cancelUser;
                        if (cancelUser) {
                            cancelUser = cancelUser.name + ' ' + cancelUser.lastname + ' (' + cancelUser.email + ')';
                        }
                        return cancelUser;
                    }},
                    {'data': function (data, type, dataToSet) {
                        var disabled = 'disabled';
                        if (data.warehouseSourceId == warehouseId) {
                            disabled = '';
                        }
                        switch (data.status) {
                            case 1:
                                return '<button title="Imprimir transferencia" type="button" data-toggle="modal" data-target="#modal-info" onClick="printDocument(' + data.id + ')" class="btn btn-warning btn-xs"><i class="fa fa-print"></i></button><span> </span>' +
                                    '<button title="Ver detalle de transferencia" type="button" data-toggle="modal" data-target="#modal-info" onClick="detailDocument(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-list-ul"></i></button><span> </span> <br><hr style="margin:2px; border-top: 0px;">' +
                                    // '<button title="Aceptar transferencia" type="button" '+ disabled +' onClick="this.disabled=true; toSecondState(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-arrow-circle-o-up"></i></button><span> </span>' +
                                    '<button title="Aceptar transferencia" type="button" disabled onClick="this.disabled=true; toThirdState(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-arrow-circle-o-right"></i></button><span> </span>' +
                                    '<button title="Anular transferencia" type="button" '+ disabled +' onClick="this.disabled=true; deleteTransfer(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-arrow-circle-o-down"></i></button>';
                                break;
                            case 2:
                                return '<button title="Imprimir transferencia" type="button" data-toggle="modal" data-target="#modal-info" onClick="printDocument(' + data.id + ')" class="btn btn-warning btn-xs"><i class="fa fa-print"></i></button><span> </span>' +
                                    '<button title="Ver detalle de transferencia" type="button" data-toggle="modal" data-target="#modal-info" onClick="detailDocument(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-list-ul"></i></button><span> </span> <br><hr style="margin:2px; border-top: 0px;">' +
                                    // '<button title="Aceptar transferencia" type="button" '+ disabled +' disabled onClick="this.disabled=true; toSecondState(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-arrow-circle-o-up"></i></button><span> </span>' +
                                    '<button title="Aceptar transferencia"  type="button" '+ disabled +' onClick="this.disabled=true; toThirdState(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-arrow-circle-o-right"></i></button><span> </span>' +
                                    '<button title="Anular transferencia" type="button" '+ disabled +' onClick="this.disabled=true; deleteTransfer(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-arrow-circle-o-down"></i></button>';
                                break;
                            case 3:
                                var disabled_ = 'disabled';
                                // if (data.cancelDate) {
                                //     disabled_ = 'disabled';
                                // }
                                return '<button title="Imprimir transferencia" type="button" data-toggle="modal" data-target="#modal-info" onClick="printDocument(' + data.id + ')" class="btn btn-warning btn-xs"><i class="fa fa-print"></i></button><span> </span>' +
                                    '<button title="Ver detalle de transferencia" type="button" data-toggle="modal" data-target="#modal-info" onClick="detailDocument(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-list-ul"></i></button><span> </span> <br><hr style="margin:2px; border-top: 0px;">' +
                                    // '<button title="Aceptar transferencia" type="button" disabled onClick="this.disabled=true; toSecondState(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-arrow-circle-o-up"></i></button><span> </span>' +
                                    '<button title="Aceptar transferencia" type="button" disabled onClick="this.disabled=true; toThirdState(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-arrow-circle-o-right"></i></button><span> </span>' +
                                    '<button title="Anular transferencia" type="button" '+ disabled_ +' onClick="this.disabled=true; deleteTransfer(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-arrow-circle-o-down"></i></button>';
                                break;
                            default:
                                return '<button title="Imprimir transferencia" type="button" data-toggle="modal" data-target="#modal-info" onClick="printDocument(' + data.id + ')" class="btn btn-warning btn-xs"><i class="fa fa-print"></i></button><span> </span>' +
                                    '<button title="Ver detalle de transferencia" type="button" data-toggle="modal" data-target="#modal-info" onClick="detailDocument(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-list-ul"></i></button><span> </span> <br><hr style="margin:2px; border-top: 0px;">' +
                                    // '<button title="Aceptar transferencia" type="button" '+ disabled +' onClick="toSecondState(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-arrow-circle-o-up"></i></button><span> </span>' +
                                    '<button title="Aceptar transferencia" type="button" disabled onClick="toThirdState(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-arrow-circle-o-right"></i></button><span> </span>' +
                                    '<button title="Anular transferencia" type="button" '+ disabled +' disabled onClick="this.disabled=true; deleteTransfer(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-arrow-circle-o-down"></i></button>';
                                break;
                        }
                    }}
                ],
                "responsive": true
            });
        }
        callBackFunction();
        var statusId = document.getElementById('statusId');
        statusId.addEventListener('change', function() {
            callBackFunction();
        });
        //var functions
        printDocument = function(id) {
            window.open('/print-transfer-pdf-by-id/' + id);
        }
        detailDocument = function (id) {
            var modalInfoHeader = document.getElementById('modalInfoHeader');
            modalInfoHeader.innerHTML = 'Resumen de transferencia Nº ' + arrayTransfers[id].number;
                var tBodyDataInfo = document.getElementById('tBodyDataInfo');
                var table = $('#transferDataInfo').DataTable();
                table.destroy();
                $("#tBodyDataInfo tr").remove(); 
                arrayTransfers[id].details.forEach(element => {
                    if (element.product != null) {
                        var tr = document.createElement('tr');
                        var description = element.product.description;
                        if (description == null) {
                            description = 'SIN DESCRIPCIÓN';
                        }
                        var urlImage = '/img/new_ic_logo_short.png';
                        if (element.product.urlImage != null) {
                            urlImage = element.product.urlImage;
                        }
                        var trText_ = '<td><a href="'+ urlImage +'" target="_blank"><img src="' + urlImage + '" height="50px" width="50px" /></a></td>' + 
                            '<td>' + element.product.name + '</td>' +
                            '<td>' + element.product.code + '</td>' + 
                            '<td>' + element.product.autoBarcode + '</td>' +
                            '<td>' + description + '</td>' +
                            '<td>' + element.quantity + '</td>' +
                            '<td>' + element.devolution + '</td>' +
                            '<td>' + element.reason + '</td>';
                        tr.innerHTML = trText_;
                        tBodyDataInfo.insertBefore(tr, tBodyDataInfo.nextSibling);
                    }
                });
                $(function () {
                    $('#transferDataInfo').DataTable({
                        'paging'      : true,
                        'pageLength'  : 5,
                        'lengthChange': false,
                        'searching'   : true,
                        'ordering'    : true,
                        'info'        : true,
                        'autoWidth'   : true,
                        "language": {
                            "url": "/js/languages/datatables/es.json"
                        },
                        "dom": 'Bfrtip',
                        "buttons": [
                            'excel', 'pdf'
                        ],
                        "bDestroy": true
                    });
                });
            $("#modal-resume").modal({ backdrop: 'static', keyboard: false });
        }
        toSecondState = function (id) {
            //Logic
            var dataSend = {
                details : []
            };
            arrayTransfers[id].details.forEach(element => {
                if (element.product != null) {
                    var objElement = {
                        'productId': element.product.id,
                        'status': 2
                    };
                    dataSend.details.push(objElement);   
                }
            });
            //Api call
            $.ajax({
                url: '/api/transfer/' + id + '/clearance',
                context: document.body,
                method: 'PATCH',
                data: dataSend,
                statusCode: {
                    400 : function() {
                        alert("No se pudo cambiar el estado de la transferencia. Inténtelo nuevamente.");
                    }
                }
            }).done(function(response){
                window.location.href = "/transfers";
            });
        }
        toThirdState = function (id) {
            //Logic
            var dataSend = {
                details : []
            };
            arrayTransfers[id].details.forEach(element => {
                if (element.product != null) {
                    var objElement = {
                        'productId': element.product.id,
                        'status': 3
                    };
                    dataSend.details.push(objElement);   
                }
            });
            //Api call
            $.ajax({
                url: '/api/transfer/' + id + '/finished',
                context: document.body,
                method: 'PATCH',
                data: dataSend,
                statusCode: {
                    400 : function() {
                        alert("No se pudo cambiar el estado de la transferencia. Inténtelo nuevamente.");
                    }
                }
            }).done(function(response){
                window.location.href = "/transfers";
            });
        }
        deleteTransfer = function (id) {
            $('#modal-on-load').modal({backdrop: 'static', keyboard: false});
            //Api call
            $.ajax({
                url: '/api/transfer/' + id + '/cancel',
                context: document.body,
                method: 'PATCH',
                statusCode: {
                    400 : function() {
                        alert("No se pudo cambiar el estado de la transferencia. Inténtelo nuevamente.");
                    }
                }
            }).done(function(response){
                window.location.href = "/transfers";
            });
        }
    });
</script>