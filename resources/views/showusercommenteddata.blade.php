@extends('layouts.app')

@push('head')
    <title>Agent commented data</title>

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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->

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


    <link type="text/css" href="{{ asset('css/dataTables.checkboxes.css') }}" rel="stylesheet" />
    <script type="text/javascript" src="{{ asset('js/dataTables.checkboxes.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>

    <!--  datetime range -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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
                    <div class="alert alert-error pb-3 mt-3" id="alertdata" role="alert" hidden>
                    </div>

                    <div class="card-header py-3">
                        <h3 class="m-0 font-weight-bold" style="color: #70cacc;">
                            Commented data
                        </h3>

                        <div class="alert alert-danger pb-3 mt-3" role="alert" id="alertdiv" hidden>
                        </div>

                    </div>

                    <div class="card-body mt-3">
                        <div class="table-responsive" style="max-height:278vh;overflow:scroll">
                            <div class="row">
                                <div class="col-md-3 mb-1 ml-5">Agent name</div>
                                <div class="col-md-3 mb-1 ml-5">Customer status</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-5 ml-5">
                                    <select id="userid" class="form-control">
                                        <option value="">All</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-5 ml-5">
                                    <select id="userstatus" class="form-control">
                                        <option value="">All</option>
                                        @foreach ($userstatus as $item)
                                            <option value="{{ $item }}">{{ ucfirst($item) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <table class="table table-bordered table-hover" style="width: 600%" id="dataTable">
                                <thead style="background: #70cacc;color: aliceblue;">
                                    <tr>
                                        <th>
                                            <div class="row">Unique&nbsp&nbsp<div data-toggle="tooltip"
                                                    data-placement="right" title="Project unit"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-info-circle-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                    </svg></div>
                                            </div>
                                        </th>
                                        <th>Name</th>
                                        <th>Comment</th>
                                        <th>Customer status</th>
                                        <th>Phone</th>
                                        <th>whatsup phone</th>
                                        <th>Mobile</th>
                                        <th>whatsup mobile</th>
                                        <th>Secondary mobile</th>
                                        <th>whatsup secondary mobile</th>
                                        <th>Email</th>
                                        <th>
                                            <div class="row">P-number&nbsp&nbsp<div data-toggle="tooltip"
                                                    data-placement="right" title="Plot Number"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-info-circle-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                    </svg></div>
                                            </div>
                                        </th>
                                        <th>Area</th>
                                        <th>Usage</th>
                                        <th>Total area</th>
                                        <th>Plot number</th>
                                        <th>Emirate</th>
                                        <th>Area owned</th>
                                        <th>Address</th>
                                        <th>Fax</th>
                                        <th>Po box</th>
                                        <th>Gender</th>
                                        <th>
                                            <div class="row">DOB&nbsp&nbsp<div data-toggle="tooltip"
                                                    data-placement="right" title="Date of birthday"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-info-circle-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                    </svg></div>
                                            </div>
                                        </th>
                                        <th>Passport</th>
                                        <th>Issue date</th>
                                        <th>Expiry date</th>
                                        <th>Place of issue</th>
                                        <th>Emirates id number</th>
                                        <th>Emirates id expiry date</th>
                                        <th>Residence country</th>
                                        <th>Nationality</th>
                                        <th>Master project</th>
                                        <th>Project</th>
                                        <th>Building name</th>
                                        <th>Agents</th>
                                        <th>Flat number</th>
                                        <th>No of beds</th>
                                        <th>Floor</th>
                                        <th>Registration number</th>
                                        <th>Lat</th>
                                        <th>Lang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>
                        {{-- info --}}
                        <div id="div1" class="row mt-5 mb-5">
                            <div class="card text-white bg-primary d-flex justify-content-center"
                                style="max-width: 12rem; font-size: smaller">
                                <div class="card-header" style="color: black">Total calls</div>
                                <div class="card-body">
                                    <h3 id="total" style="color: black;" class="card-text d-flex justify-content-center">
                                        {{ isset($total) ? $total : 0 }}</h3>
                                </div>
                            </div>

                            <div class="card text-white d-flex justify-content-center"
                                style="max-width: 8rem; font-size: smaller">
                                <div class="card-header" style="color: black">Interested</div>
                                <div class="card-body" style="color: black; background-color: #FEFEE7">
                                    <h3 id="interested" class="card-text d-flex justify-content-center">
                                        {{ isset($interested) ? $interested : 0 }}</h3>
                                </div>
                            </div>
                            <div class="card text-white d-flex justify-content-center"
                                style="max-width: 12rem; font-size: smaller">
                                <div class="card-header" style="color: black">Not interested</div>
                                <div class="card-body" style="color: black;background-color: red">
                                    <h3 id="notinterested" class="card-text d-flex justify-content-center">
                                        {{ isset($notinterested) ? $notinterested : 0 }}</h3>
                                </div>
                            </div>
                            <div class="card text-white d-flex justify-content-center"
                                style="max-width: 10rem; font-size: smaller">
                                <div class="card-header" style="color: black">Not answer</div>
                                <div class="card-body" style="color: black;background-color: brown">
                                    <h3 id="notanswer" class="card-text d-flex justify-content-center">
                                        {{ isset($notanswer) ? $notanswer : 0 }}</h3>
                                </div>
                            </div>
                            <div class="card text-white d-flex justify-content-center"
                                style="max-width: 28rem; font-size: smaller">
                                <div class="card-header" style="color: black">Number unavailable/Not working for
                                    call/Incomplete no</div>
                                <div class="card-body" style="color: black;background-color: orange">
                                    <h3 id="unavnotworkincomp" class="card-text d-flex justify-content-center">
                                        {{ isset($unavnotworkincomp) ? $unavnotworkincomp : 0 }}</h3>
                                </div>
                            </div>
                            <div class="card text-white d-flex justify-content-center"
                                style="max-width: 28rem; font-size: smaller">
                                <div class="card-header" style="color: black">Switch off/Line busy/Wrong
                                    number/Invalid
                                    number</div>
                                <div class="card-body" style="color: black;background-color: #AED6F1">
                                    <h3 id="swoflibuwonuinnu" class="card-text d-flex justify-content-center">
                                        {{ isset($swoflibuwonuinnu) ? $swoflibuwonuinnu : 0 }}</h3>
                                </div>
                            </div>
                            <div class="card text-white d-flex justify-content-center"
                                style="max-width: 10rem; font-size: smaller">
                                <div class="card-header" style="color: black">Others</div>
                                <div class="card-body" style="color: black;background-color: #DAF7A6">
                                    <h3 id="others" class="card-text d-flex justify-content-center">
                                        {{ isset($others) ? $others : 0 }}</h3>
                                </div>
                            </div>

                            <div class="card text-white d-flex justify-content-center"
                                style="max-width: 10rem; font-size: smaller">
                                <div class="card-header" style="color: black">Set appointment</div>
                                <div class="card-body" style="color: black;background-color: #F9C4F8">
                                    <h3 id="setappointment" class="card-text d-flex justify-content-center">
                                        {{ isset($setappointment) ? $setappointment : 0 }}</h3>
                                </div>
                            </div>
                        </div>

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
        let table = $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true,
            "pageLength": 100,
            "deferRender": true,
            "paging": true,
            "pagingType": "full_numbers",
            "ajax": {
                "url": "{{ route('get_commented_user_data') }}",
                "dataType": "json",
                "type": "POST",
                data: function(d) {
                    return $.extend({}, d, {
                        _token: "{{ csrf_token() }}",
                        "userid": $('#userid').val(),
                        "userstatus": $('#userstatus').val(),
                    });
                },
                beforeSend: function() {
                    $("#parent").LoadingOverlay("show", {
                        background: "rgba(78, 115, 223, 0.5)"
                    });
                },
                complete: function() {
                    $("#parent").LoadingOverlay("hide", true);
                    getcommentsinfo();
                }
            },
            "columns": [{
                    data: "unique",
                    width: '100px'
                },
                {
                    data: "NAME",
                    width: '300px'
                },
                {
                    data: "comments",
                    width: '400px'
                },
                {
                    data: "userstatus",
                    width: '100px'
                },
                {
                    data: "PHONE",
                    width: '100px'
                },
                {
                    "data": "phone_whatsup",
                    "render": function(data, type, row, meta) {
                        if (data != '-' && data != '') {
                                return data = '<a href="' + "https://api.whatsapp.com/send?phone=" +
                                    data + '" target="_blank">' +
                                    "https://api.whatsapp.com/send?phone=" + data + '</a>';
                            } else
                                return data;
                    }
                },
                {
                    data: "MOBILE",
                    width: '100px'
                },
                {
                    "data": "MOBILE_whatsup",
                    "render": function(data, type, row, meta) {
                        if (data != '-' && data != '') {
                                return data = '<a href="' + "https://api.whatsapp.com/send?phone=" +
                                    data + '" target="_blank">' +
                                    "https://api.whatsapp.com/send?phone=" + data + '</a>';
                            } else
                                return data;
                    }
                },
                {
                    data: "SECONDARY_MOBILE",
                    width: '150px'
                },
                {
                    "data": "SECONDARY_MOBILE_wahtsup",
                    "render": function(data, type, row, meta) {
                        if (data != '-' && data != '') {
                                return data = '<a href="' + "https://api.whatsapp.com/send?phone=" +
                                    data + '" target="_blank">' +
                                    "https://api.whatsapp.com/send?phone=" + data + '</a>';
                            } else
                                return data;
                    }
                },
                {
                    data: "EMAIL",
                    width: '100px'
                },
                {
                    data: "P_NUMBER",
                    width: '100px'
                },
                {
                    data: "AREA",
                    width: '100px'
                },
                {
                    data: "USAGE",
                    width: '100px'
                },
                {
                    data: "TOTAL_AREA",
                    width: '100px'
                },
                {
                    data: "PLOT_NUMBER",
                    width: '100px'
                }, {
                    data: "EMIRATE",
                    width: '100px'
                },
                {
                    data: "AREA_OWNED",
                    width: '100px'
                }, {
                    data: "ADDRESS",
                    width: '300px'
                },
                {
                    data: "FAX",
                    width: '100px'
                }, {
                    data: "PO_BOX",
                    width: '100px'
                }, {
                    data: "GENDER",
                    width: '50px'
                }, {
                    data: "DOB",
                    width: '100px'
                },
                {
                    data: "PASSPORT",
                    width: '100px'
                }, {
                    data: "ISSUE_DATE",
                    width: '100px'
                }, {
                    data: "EXPIRY_DATE",
                    width: '100px'
                }, {
                    data: "PLACE_OF_ISSUE",
                    width: '150px'
                }, {
                    data: "EMIRATES_ID_NUMBER",
                    width: '140px'
                }, {
                    data: "EMIRATES_ID_EXPIRY_DATE",
                    width: '200px'
                },
                {
                    data: "RESIDENCE_COUNTRY",
                    width: '150px'
                }, {
                    data: "NATIONALITY",
                    width: '100px'
                }, {
                    data: "Master_Project",
                    width: '100px'
                }, {
                    data: "Project",
                    width: '100px'
                }, {
                    data: "Building_Name",
                    width: '100px'
                }, {
                    data: "Agents",
                    width: '100px'
                }, {
                    data: "Flat_Number",
                    width: '100px'
                },
                {
                    data: "No_of_Beds",
                    width: '100px'
                }, {
                    data: "Floor",
                    width: '100px'
                }, {
                    data: "registration_number",
                    width: '200px'
                }, {
                    data: "lat",
                    width: '100px'
                }, {
                    data: "lng",
                    width: '100px'
                }
            ],
            "lengthMenu": [
                [100, 500, 1000, 2000, 5000, 10000],
                [100, 500, 1000, 2000, 5000, 10000]
            ],
            "buttons": [{
                    "extend": 'excel',
                    "action": newexportaction,
                },
                {
                    "extend": 'csv',
                    "action": newexportaction
                }
            ],
            "dom": 'Blftip',
            initComplete: function() {
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

        function getcommentsinfo() {
            // get comments data
            $.ajax({
                url: "{{ route('get_user_commented_info') }}",
                dataType: "json",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    "userid": $('#userid').val(),
                    "userstatus": $('#userstatus').val()
                },
                success: function(result) {
                    $("#swoflibuwonuinnu").text(result.swoflibuwonuinnu);
                    $("#unavnotworkincomp").text(result.unavnotworkincomp);
                    $("#others").text(result.others);
                    $("#interested").text(result.interested);
                    $("#notinterested").text(result.notinterested);
                    $("#notanswer").text(result.notanswer);
                    $("#setappointment").text(result.setappointment);
                    $("#total").text(result.total);
                }
            })
        }

        $(document).ready(function() {
            $('#userid').change(function() {
                $("#alertdata").empty();
                $('#dataTable').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "userid": $('#userid').val(),
                    "userstatus": $('#userstatus').val()
                }, );
                $('#dataTable').DataTable().draw();
            });

            $('#userstatus').change(function() {
                $("#alertdata").empty();
                $('#dataTable').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "userid": $('#userid').val(),
                    "userstatus": $('#userstatus').val()
                }, );
                $('#dataTable').DataTable().draw();
            });
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
    </script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

@endpush
