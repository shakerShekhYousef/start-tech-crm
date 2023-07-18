@extends('layouts.app')
@push('head')

    <title>Show inventories</title>

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
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.0/css/colReorder.bootstrap.min.css">
    <script src="https://cdn.datatables.net/colreorder/1.5.0/js/dataTables.colReorder.min.js"></script>

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
                            Show inventories
                        </h3>

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
                        <table class="table table-bordered table-hover" style="width: 600%" id="dataTable">
                            <thead style="background: #70cacc;color: aliceblue;">
                                <tr>
                                    <th>id</th>
                                    <th>Serial number</th>
                                    <th>Date listed</th>
                                    <th>Agent name</th>
                                    <th>Category</th>
                                    <th>Building status</th>
                                    <th>Client name</th>
                                    <th>Unit for sales</th>
                                    <th>Unit number</th>
                                    <th>Community location</th>
                                    <th>Property type</th>
                                    <th>Bedrooms</th>
                                    <th>Specifications</th>
                                    <th>Property size</th>
                                    <th>Price aed</th>
                                    <th>Remarks</th>
                                    <th>Source of lead</th>
                                    <th>Developer</th>
                                    <th>Building name</th>
                                    <th>Property name</th>
                                    <th>Plot area</th>
                                    <th>Customer name</th>
                                    <th>Email address</th>
                                    <th>Mobile</th>
                                    <th>Comments</th>
                                    <th>Nationality</th>
                                    <th>Furniture</th>
                                    <th>Customer type</th>
                                    <th>Can add</th>
                                    <th>Roi</th>
                                    <th>Telephone number</th>
                                    <th>Telephone residence</th>
                                    <th>Telephone office</th>
                                    <th>General</th>
                                    <th>Property finder link</th>
                                    <th>Buyut link</th>
                                    <th>Dubizzle link</th>
                                    <th>Wow propties link</th>
                                    <th>Other links</th>
                                    <th>Floors</th>
                                    <th>Service charge</th>
                                    <th>Payment plan</th>
                                    <th>Rent</th>
                                    <th>Ready/off</th>
                                    <th>Handover</th>
                                    <th>Bathrooms</th>
                                    <th>Completion</th>
                                    <th>Customer status</th>
                                    <th>Floor plan/view</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <input id="startdate" type="text" hidden>
                                <input id="enddate" type="text" hidden>
                            </tbody>
                        </table>

                        <div class="row mt-2">
                            <div id="tableinfo" class="col-md-6 d-flex justify-content-start"></div>
                            <div id="tablepaginate" class="col-md-6 d-flex justify-content-end"></div>
                        </div>
                    </div>


                </div>

            </div>
            <!-- /.container-fluid -->

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
                colReorder: true,
                "ordering": false,
                "processing": true,
                "serverSide": true,
                scrollY: 500,
                scrollX: true,
                scrollCollapse: true,
                "pageLength": 100,
                "paging": true,
                "pagingType": "full_numbers",
                "ajax": {
                    "url": "{{ route('get_inventories') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d._token = "{{ csrf_token() }}";
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
                        width: '50px',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "serial_num",
                        width: '200px',
                        orderable: false
                    },
                    {
                        data: "date_listed",
                        width: '200px',
                    },
                    {
                        data: "agent_name",
                        width: '200px'
                    },
                    {
                        data: "category",
                        width: '200px'
                    },
                    {
                        data: "building_status",
                        width: '200px'
                    },
                    {
                        data: "client_name",
                        width: '200px'
                    },
                    {
                        data: "unit_for_sales",
                        width: '200px'
                    },
                    {
                        data: "unit_number",
                        width: '200px'
                    },
                    {
                        data: "community_location",
                        width: '200px'
                    },
                    {
                        data: "property_type",
                        width: '200px'
                    },
                    {
                        data: "bedrooms",
                        width: '200px'
                    },
                    {
                        data: "specifications",
                        width: '200px'
                    },
                    {
                        data: "property_size",
                        width: '200px'
                    },
                    {
                        data: "price_aed",
                        width: '200px'
                    },
                    {
                        data: "remarks",
                        width: '200px'
                    },
                    {
                        data: "source_of_lead",
                        width: '200px'
                    },
                    {
                        data: "developer",
                        width: '200px'
                    },
                    {
                        data: "building_name",
                        width: '200px'
                    },
                    {
                        data: "property_name",
                        width: '200px'
                    },
                    {
                        data: "plot_area",
                        width: '200px'
                    },
                    {
                        data: "customer_name",
                        width: '200px'
                    },
                    {
                        data: "email_address",
                        width: '200px'
                    },
                    {
                        data: "mobile",
                        width: '200px'
                    },
                    {
                        data: "comments",
                        width: '200px'
                    },
                    {
                        data: "nationality",
                        width: '200px'
                    },
                    {
                        data: "furniture",
                        width: '200px'
                    },
                    {
                        data: "customer_type",
                        width: '200px'
                    },
                    {
                        data: "can_add",
                        width: '200px'
                    },
                    {
                        data: "roi",
                        width: '200px'
                    },
                    {
                        data: "telephone_number",
                        width: '200px'
                    },
                    {
                        data: "telephone_residence",
                        width: '200px'
                    },
                    {
                        data: "telephone_office",
                        width: '200px'
                    },
                    {
                        data: "general",
                        width: '200px'
                    },
                    {
                        data: "property_finder_link",
                        width: '200px'
                    },
                    {
                        data: "buyut_link",
                        width: '200px'
                    },
                    {
                        data: "dubizzle_link",
                        width: '200px'
                    },
                    {
                        data: "wow_propties_link",
                        width: '200px'
                    },
                    {
                        data: "other_links",
                        width: '200px'
                    },
                    {
                        data: "floors",
                        width: '200px'
                    },
                    {
                        data: "service_charge",
                        width: '200px'
                    },
                    {
                        data: "payment_plan",
                        width: '200px'
                    },
                    {
                        data: "rent",
                        width: '200px'
                    },
                    {
                        data: "ready_off",
                        width: '200px'
                    },
                    {
                        data: "handover",
                        width: '200px'
                    },
                    {
                        data: "bathrooms",
                        width: '200px'
                    },
                    {
                        data: "completion",
                        width: '200px'
                    },
                    {
                        data: "status",
                        width: '200px'
                    },
                    {
                        data: "image",
                        width: '200px'
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
                "dom": 'Blftip',
                "buttons": [{
                        "extend": 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                header: function(data, column, row) {
                                    return data.split('<')[0];
                                }
                            }
                        }
                    },
                    {
                        "extend": 'csv',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                header: function(data, column, row) {
                                    return data.split('<')[0];
                                }
                            }
                        }
                    }
                ],
                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        var select = $(
                                '<select class="w-100"><option value=""></option></select>')
                            .appendTo($(column.header()))
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d + '">' + d +
                                '</option>')
                        });
                    });

                    // 
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
            $("div.dataTables_filter input").unbind();
            $("div.dataTables_filter input").keyup(function(
                e) {
                console.log(e.keyCode);
                if (e.keyCode == 13) {
                    table.search(this.value).draw();
                }
            });

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

            $('#customertype').change(function() {
                table.draw();
            });

            $('#bedrooms').change(function() {
                table.draw();
            });

            $('#propertiessize').change(function() {
                table.draw();
            });

            $('#floors').change(function() {
                table.draw();
            });

            // Delete a record
            $('body').on('click', '.delete', function() {
                var id = table.row(this.closest('tr')).data()['id'];
                swal({
                    title: 'Are you sure?',
                    text: 'Data will be permanantly deleted!',
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
                            url: "{{ route('delete_inventory') }}",
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

    <script>
        $(document).ready(function() {

            $('div#emirates').show();
            $('div#usage').hide();
            $('div#nationality').hide();

        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>

@endpush
