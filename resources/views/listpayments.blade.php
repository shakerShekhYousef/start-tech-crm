@extends('layouts.app')
@push('head')

    <title>Home</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


    <!-- Custom styles for this page -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link rel="stylesheet" href="images/css/dash.css">
    <style>
        html {
            scroll-behavior: smooth;
        }

        nav.justify-between svg {
            width: 3%;
        }

        nav.justify-between,
        .leading-5 {
            margin-top: 15px;
        }


        .items-center .justify-between {
            display: none;
        }

    </style>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->

    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js">
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.js"
        crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.css"
        crossorigin="anonymous" />

    <!--datatable-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.js">
    </script>

    <!--  datetime range -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


    {{-- swal alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush

@section('wrapper_content')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Begin Page Content -->
            <div class="container-fluid" style="margin-top:1.5rem">

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800"></h1>



                <!-- DataTales Example -->
                <div id="parent" class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h3 class="m-0 font-weight-bold" style="color: #70cacc;">
                            Show Payments
                        </h3>

                        <div class=" pb-3 mt-3" role="alert" id="alertdiv" hidden>
                        </div>

                        <input value="" type="text" name="search" id="filter" hidden />
                        <div class="row mt-5 ml-5 mr-5 mb-5">
                            <div class="col-md-4">
                                <select name="username" class="form-control filter" id="username"
                                    style="font-size:.7rem;font-weight:bold">
                                    <option selected value="">Buyer name</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="propertyname" class="form-control filter" id="propertyname"
                                    style="font-size:.7rem;font-weight:bold">
                                    <option selected value="">Property name</option>
                                    @foreach ($properties as $property)
                                        <option value="{{ $property->name }}">{{ ucfirst($property->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-4">
                        @if (Auth::user()->isadmin())
                            <div class="col-md-3 d-flex justify-content-start">
                                <div id="tablebuttoncsv" class="mr-1 ml-3"></div>
                                <div id="tablebuttonexcel" class="mr-1"></div>
                                <div id="tablebuttonpdf" class="mr-1"></div>
                            </div>
                        @endif
                    </div>

                    <div class="card-body mt-3">

                        <div class="table-responsive" style="max-height:278vh;overflow:scroll">
                            <table class="table table-bordered table-hover" id="dataTable">
                                <thead style="background: #70cacc;color: aliceblue;">
                                    <tr>
                                        <th>id</th>
                                        <th>Buyer name</th>
                                        <th>Property</th>
                                        <th>Payment amount</th>
                                        <th>Payment date</th>
                                        <th>Payment status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <input id="startdate" type="text" hidden>
                                    <input id="enddate" type="text" hidden>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-2">
                            <div id="tableinfo" class="col-md-6 d-flex justify-content-start"></div>
                            <div id="tablepaginate" class="col-md-6 d-flex justify-content-end"></div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- /.container-fluid -->

            <div class="row">
                <div class="col-md-3 ml-4">
                    <div class="card text-white bg-primary d-flex justify-content-center" style="max-width: 14rem;">
                        <div class="card-header" style="color: black">Total properties count</div>
                        <div class="card-body">
                            <h3 id="totalpropertiescount" class="card-text d-flex justify-content-center">
                                {{ isset($totalpropertiescount) ? $totalpropertiescount : 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-primary d-flex justify-content-center" style="max-width: 14rem;">
                        <div class="card-header" style="color: black">Total payments count</div>
                        <div class="card-body">
                            <h3 id="totalpaymentscount" class="card-text d-flex justify-content-center">
                                {{ isset($totalpaymentscount) ? $totalpaymentscount : 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-primary d-flex justify-content-center" style="max-width: 14rem;">
                        <div class="card-header" style="color: black">Total payments amount</div>
                        <div class="card-body">
                            <h3 id="totalpaymentsamount" class="card-text d-flex justify-content-center">
                                {{ isset($totalpaymentsamount) ? $totalpaymentsamount : 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">

            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->
@endsection

@section('content')
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'center',
                ranges: {
                    '1900-1950': ['1/1/1900', '1/1/1950'],
                    '1950-2000': ['1/1/1950', '1/1/2000'],
                    '2000-2050': ['1/1/2000', '1/1/2050'],
                    '2050-3000': ['1/1/2050', '1/1/3000'],
                },
                "showDropdowns": false,
                "startDate": "01/01/1900",
                "endDate": Date.now(),
                "minYear": 1900,
                "maxYear": 3000,
            }, function(start, end, label) {
                $('#startdate').val(start.format('YYYY-MM-DD'));
                $('#enddate').val(end.format('YYYY-MM-DD'));
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            let table = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 100,
                'bPaginate': false,
                "ajax": {
                    "url": "{{ route('list_payments') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        return $.extend({}, d, {
                            _token: "{{ csrf_token() }}",
                            "userid": $('#username').val(),
                            "propertyname": $('#propertyname').val()
                        });
                    },
                    beforeSend: function() {
                        $("#parent").LoadingOverlay("show", {
                            background: "rgba(78, 115, 223, 0.5)"
                        });
                    },
                    complete: function() {
                        $("#parent").LoadingOverlay("hide", true);
                    }
                },
                "columns": [{
                        data: "DT_RowIndex",
                        width: '100px'
                    },
                    {
                        data: "Buyer_name1",
                        width: '200px'
                    },
                    {
                        data: "property",
                        width: '200px'
                    },
                    {
                        data: "payment_amount",
                        width: '200px',
                        render: function(val) {
                            return parseFloat(val).toLocaleString();
                        }
                    },
                    {
                        data: "date_of_payment",
                        width: '200px'
                    },
                    {
                        data: "payment_status",
                        width: '200px',
                        render: function(val) {
                            if (val == 0)
                                return 'UnPaid';
                            else if (val == 1)
                                return 'Paid';
                            else
                                return '';
                        }
                    },
                    {
                        data: "action",
                        width: '200px'
                    }
                ],
                "lengthMenu": [
                    [100, 500, 1000, 2000, 5000, 10000],
                    [100, 500, 1000, 2000, 5000, 10000]
                ],
                dom: 'lftipB',
                "paging": true,
                "buttons": [{
                        "extend": 'excel',
                        "action": newexportaction,
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        "extend": 'csv',
                        "action": newexportaction,
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    }
                ],
                initComplete: (settings, json) => {
                    $('#tablepaginate').empty();
                    $('#dataTable_paginate').appendTo('#tablepaginate');
                    $('#tableinfo').empty();
                    $('#dataTable_info').appendTo('#tableinfo');
                    $('#tablebuttoncsv').empty();
                    $('.btn.btn-secondary.buttons-csv.buttons-html5').appendTo(
                        '#tablebuttoncsv');
                    $('#tablebuttonexcel').empty();
                    $('.btn.btn-secondary.buttons-excel.buttons-html5').appendTo(
                        '#tablebuttonexcel');
                    $('#tablebuttonpdf').empty();
                    $('.btn.btn-secondary.buttons-pdf.buttons-html5').appendTo(
                        '#tablebuttonpdf');
                }
            });

            table.on('draw', function(e) {
                $('#dataTable').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "username": $('#username').val(),
                    "propertyname": $('#propertyname').val()
                }, );

                // get payments info
                $.ajax({
                    url: "{{ route('get_customer_payments_info') }}",
                    dataType: "json",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        "userid": $('#username').val(),
                        "propertyname": $('#propertyname').val()
                    },
                    success: function(result) {
                        $("#totalpropertiescount").text(result.totalpropertiescount);
                        $("#totalpaymentscount").text(result.totalpaymentscount);
                        $("#totalpaymentsamount").text(result.totalpaymentsamount);
                    }
                })
            })

            $("div.dataTables_filter input").unbind();
            $("div.dataTables_filter input").keyup(function(
                e) {
                console.log(e.keyCode);
                if (e.keyCode == 13) {
                    table.search(this.value).draw();
                }
            });

            $('#dataTable').DataTable().draw();

            function newexportaction(e, dt, button, config) {
                var self = this;
                var oldStart = dt.settings()[0]._iDisplayStart;
                dt.one('preXhr', function(e, s, data) {
                    // Just this once, load all data from the server...
                    data.start = 0;
                    data.length = 2147483647;
                    dt.one('preDraw', function(e, settings) {
                        // Call the original action function
                        if (button[0].className.indexOf('buttons-copy') >= 0) {
                            $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt,
                                button, config);
                        } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                            $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt,
                                    button, config) :
                                $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt,
                                    button, config);
                        } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                            $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt,
                                    button, config) :
                                $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt,
                                    button, config);
                        } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                            $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt,
                                    button, config) :
                                $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt,
                                    button, config);
                        } else if (button[0].className.indexOf('buttons-print') >= 0) {
                            $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                        }
                        dt.one('preXhr', function(e, s, data) {
                            // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                            // Set the property to what it was before exporting.
                            settings._iDisplayStart = oldStart;
                            data.start = oldStart;
                        });
                        // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                        setTimeout(dt.ajax.reload, 0);
                        // Prevent rendering of the full data to the DOM
                        return false;
                    });
                });
                // Requery the server with the new one-time export settings
                dt.ajax.reload();
            }

            $('#username').change(function(e) {
                $('#dataTable').DataTable().draw();
            });

            $('#propertyname').change(function(e) {
                $('#dataTable').DataTable().draw();
            })

            $('#dataTable').on('search.dt', function() {
                var value = $('.dataTables_filter input').val();
                var s = $('#filter:text').val(value);
                $('#alertdiv').attr('hidden', true);
            });

            // Delete a record
            $('body').on('click', '.delete', function() {
                var id = table.row(this.closest('tr')).data()['id'];
                swal({
                    title: 'Are you sure?',
                    text: 'This record and it`s details will be permanantly deleted!',
                    icon: 'warning',
                    buttons: ["Cancel", "Yes!"],
                }).then(function(value) {
                    if (value) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        // ajax
                        $.ajax({
                            type: "POST",
                            url: "{{ route('delete_payment') }}",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function(result) {
                                if (result.success) {
                                    $('#alertdiv').empty();
                                    $('#alertdiv').append(
                                        "<div class= 'alert alert-success'>" +
                                        result
                                        .message +
                                        "</div>");
                                    $('#alertdiv').attr('hidden', false);
                                    table.clear().draw();
                                } else {
                                    $('#alertdiv').empty();
                                    $('#alertdiv').append(
                                        "<div class= 'alert alert-danger'>" +
                                        result
                                        .message +
                                        "</div>");
                                    $('#alertdiv').attr('hidden', false);
                                }
                            },
                            error: function(erorr) {
                                console.log(erorr);
                            }
                        });
                    }
                });
            });
        });
    </script>


    <!-- jQuery library -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>

@endpush
