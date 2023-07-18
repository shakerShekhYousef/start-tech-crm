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

        /* add model */
        .openBtn {
            display: flex;
            justify-content: left;
        }

        .openButton {
            border: none;
            border-radius: 5px;
            background-color: #1c87c9;
            color: white;
            padding: 14px 20px;
            cursor: pointer;
            position: fixed;
        }

        .loginPopup {
            position: relative;
            text-align: center;
            width: 100%;
        }

        .formPopup {
            display: none;
            position: fixed;
            left: 45%;
            top: 5%;
            transform: translate(-50%, 5%);
            border: 3px solid #999999;
            z-index: 9;
        }

        .formContainer {
            max-width: 300px;
            padding: 20px;
            background-color: #fff;
        }

        .formContainer input[type=text],
        .formContainer input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 20px 0;
            border: none;
            background: #eee;
        }

        .formContainer input[type=text]:focus,
        .formContainer input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        .formContainer .btn {
            padding: 12px 20px;
            border: none;
            background-color: #8ebf42;
            color: #fff;
            cursor: pointer;
            width: 100%;
            margin-bottom: 15px;
            opacity: 0.8;
        }

        .formContainer .cancel {
            background-color: #cc0000;
        }

        .formContainer .btn:hover,
        .openButton:hover {
            opacity: 1;
        }

        /* end add model */

    </style>

    <!-- Page level plugins -->

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.css"
        crossorigin="anonymous" />

    <!--datatable-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css" />


    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker-standalone.css">

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
                            Show Data
                        </h3>

                        <div class="card-bod" style="width: 96%; margin-left: 2%">
                            <span id="alertdata"></span>

                            <div class="alert alert-danger pb-3 mt-3" role="alert" id="alertdiv" hidden>
                            </div>

                            <input id="filtertype" name="filtertype" type="text" value="0" hidden>


                            {{-- mdoel form --}}
                            <div class="loginPopup">
                                <div class="formPopup" id="popupForm">
                                    <form id="" class="formContainer">
                                        <h4>Please enter appointment details</h4>
                                        <input type="text" placeholder="Enter Payment Date" name="Paymentdate"
                                            id="datetimepicker" required>
                                        <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
                                    </form>
                                </div>
                            </div>

                            <div class="row mt-5 mb-4 ml-5">

                                <div class="col-md-3">
                                    <input class="form-control" type="text" id="daymonthvalue" placeholder="DD-MM"
                                        maxlength="5">
                                </div>
                                <div class="col-md-2">
                                    <input type="button" value="filter" class="btn btn-sm btn-outline-primary ml-2 mt-2"
                                        style="font-size:.7rem;font-weight:bold" id="daymonthfilter">
                                </div>

                                <!-- choose range date -->
                                <div class="col-md-4">
                                    <div class="input-group date mb-3" id="datetimepicker2">
                                        <label for="rangedate" class="mt-2">Range date</label>
                                        <input id="rangedate" type="text" name="daterange"
                                            class="form-control datetimepicker-input ml-3" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <input type="button" value="filter range"
                                        class="btn btn-sm btn-outline-primary ml-2 mt-2"
                                        style="font-size:.7rem;font-weight:bold" id="rangefilter">
                                </div>
                            </div>

                            <input value="" type="text" name="search" id="filter" hidden />
                            <div class="row mt-5 ml-5 mr-5 mb-5">
                                <div class="col-md-4">
                                    <select name="area" class="form-control filter" id="sel1"
                                        style="font-size:.7rem;font-weight:bold">
                                        <option selected value="Show">Area</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->AREA }}">{{ $area->AREA }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="emirate" class="form-control filter1" id="sel1"
                                        style="font-size:.7rem;font-weight:bold">
                                        <option selected value="Show">Emirates</option>
                                        @foreach ($emirates as $emirate)
                                            <option value="{{ $emirate->EMIRATE }}">{{ $emirate->EMIRATE }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">

                                    <select name="residence" class="form-control filter2" id="sel1"
                                        style="font-size:.7rem;font-weight:bold">
                                        <option selected value="Show">Residence Country</option>
                                        @foreach ($residences as $residence)
                                            <option value="{{ $residence->RESIDENCE_COUNTRY }}">
                                                {{ $residence->RESIDENCE_COUNTRY }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="row">
                                <label for="" style="margin-left: 5%">Comment</label>
                            </div>
                            <div class="row">
                                <textarea style="width: 90%; overflow: scroll; height: 10%; margin-left: 5%" name=""
                                    id="commentvalue" cols="30" rows="10"></textarea>
                            </div>

                            <div class="col-md-4 ml-5 mt-3">
                                <label for="">User status</label>
                            </div>
                            <div class="col-md-4 ml-5">
                                <select name="userstatus" class="form-control" id="userstatus"
                                    style="font-size:.7rem;font-weight:bold">
                                    <option selected value="">User status</option>
                                    @foreach ($userstates as $userstate)
                                        <option value="{{ $userstate }}">{{ $userstate }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <button id="addcomment" class="btn btn-info mt-3" style="margin-left: 91.5%"> Add </button>
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

                        <table class="table table-bordered table-hover" style="width: 600%" id="dataTable">
                            <thead style="background: #70cacc;color: aliceblue;">
                                <tr>
                                    <th>Check</th>
                                    <th>
                                        <div class="row">Unique&nbsp&nbsp<div data-toggle="tooltip"
                                                data-placement="right" title="Project unit"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                </svg></div>
                                        </div>
                                    </th>
                                    <th>Name</th>
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
                                                    fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
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
                                                    fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
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
                                    <th>Source</th>
                                    <th>Hascomment</th>
                                    <th>dataid</th>
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
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js">
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.js"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.js">
    </script>
    <!--  datetime range -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js">
    </script>

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

            $('#datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss'
            });

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
                    "url": "{{ route('allposts') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        return $.extend({}, d, {
                            _token: "{{ csrf_token() }}",
                            "emirates": $('.filter1').val(),
                            "area": $('.filter').val(),
                            "residence": $('.filter2').val(),
                            "startdate": $('#startdate').val(),
                            "enddate": $('#enddate').val(),
                            'searchday': $('#daymonthvalue').val(),
                            'filtertype': $('#filtertype').val()
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
                        data: "check",
                        width: '50px'
                    },
                    {
                        data: "unique",
                        width: '200px'
                    },
                    {
                        data: "NAME",
                        width: '300px'
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
                    },
                    {
                        data: "source",
                        width: '150px'
                    }, {
                        data: "hascomment",
                        width: '150px',
                        visible: false
                    },
                    {
                        data: "dataid",
                        width: '150px',
                        visible: false
                    }
                ],
                "lengthMenu": [
                    [100, 500, 1000, 2000, 5000, 10000],
                    [100, 500, 1000, 2000, 5000, 10000]
                ],
                "dom": 'lftip',
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                }],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
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

            $(".filter1,.filter,.filter2").change(function(e) {
                $('#alertdiv').attr('hidden', true);
                $("#alertdata").empty();
                $('#dataTable').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "emirates": $('.filter1').val(),
                    "area": $('.filter').val(),
                    "residence": $('.filter2').val(),
                    "startdate": $('#startdate').val(),
                    "enddate": $('#enddate').val(),
                    'searchday': $('#daymonthvalue').val(),
                    'filtertype': $('#filtertype').val()
                }, );
                $('#dataTable').DataTable().draw();
            });

            var searchval = "";
            $('#daymonthvalue').keyup(function(e) {
                if (e.keyCode == 13) {
                    $('#daymonthfilter').click();
                }
                $('#alertdiv').attr('hidden', true);
                $("#alertdata").empty();
                $text = $(this);

                if ($text.val().length == 1 && parseInt($text.val()) > 3) {
                    $('#alertdiv').attr('hidden', false);
                    $('#alertdiv').text("maximum day value is 31");
                    $text.val(searchval);
                }

                if ($text.val().length == 2) {
                    if (parseInt($text.val()) > 31) {
                        $('#alertdiv').attr('hidden', false);
                        $('#alertdiv').text("maximum day value is 31");
                        $text.val(searchval);
                    }
                }
                if ($text.val().length == 3) {
                    if ((e.keyCode != 109 && e.keyCode != 189) && e.keyCode != 8) {
                        $('#alertdiv').attr('hidden', false);
                        $('#alertdiv').text("you should enter -");
                        $text.val(searchval);
                    }
                } else if ($text.val().length == 4) {
                    if (parseInt($text.val().substring(3, 4)) > 1) {
                        $('#alertdiv').attr('hidden', false);
                        $('#alertdiv').text("maximum month value is 12");
                        $text.val(searchval);
                    }
                } else if ($text.val().length == 5) {
                    if (parseInt($text.val().substring(3, 5)) > 12) {
                        $('#alertdiv').attr('hidden', false);
                        $('#alertdiv').text("maximum month value is 12");
                        $text.val(searchval);
                    }
                } else if (e.keyCode != 8) {
                    if (e.keyCode < 48 || (e.keyCode > 57 && e.keyCode < 96) || e.keyCode > 105) {
                        $('#alertdiv').attr('hidden', false);
                        $('#alertdiv').text("you should enter just numbers");
                        $text.val(searchval);
                    }
                }
                searchval = $text.val();
            });

            $('#daymonthfilter').click(function(e) {
                $('#filtertype').val('1');
                $('#alertdiv').attr('hidden', true);
                $("#alertdata").empty();
                if ($('#daymonthvalue').val().length < 5) {
                    e.preventDefault();
                    $('#alertdiv').attr('hidden', false);
                    $('#alertdiv').text("you should enter day");
                } else {
                    $('#dataTable').data("dt_params", {
                        _token: "{{ csrf_token() }}",
                        "emirates": $('.filter1').val(),
                        "area": $('.filter').val(),
                        "residence": $('.filter2').val(),
                        "startdate": $('#startdate').val(),
                        "enddate": $('#enddate').val(),
                        'searchday': $('#daymonthvalue').val(),
                        'filtertype': $('#filtertype').val()
                    }, );
                    $('#dataTable').DataTable().draw();
                }
            });

            $('#startdate').val($('input[name="daterange"]').val().split('-')[0]);
            $('#enddate').val($('input[name="daterange"]').val().split('-')[1]);

            $('#rangefilter').click(function(e) {
                $('#filtertype').val('2');
                $('#alertdiv').attr('hidden', true);
                $("#alertdata").empty();
                if ($('#startdate').val() == '' || $('#enddate').val() == '') {
                    e.preventDefault();
                    $('#alertdiv').attr('hidden', false);
                    $('#alertdiv').text("you should select start and end dates");
                } else {
                    $('#dataTable').data("dt_params", {
                        _token: "{{ csrf_token() }}",
                        "emirates": $('.filter1').val(),
                        "area": $('.filter').val(),
                        "residence": $('.filter2').val(),
                        "startdate": $('#startdate').val(),
                        "enddate": $('#enddate').val(),
                        'searchday': $('#daymonthvalue').val(),
                        'filtertype': $('#filtertype').val()
                    }, );
                    $('#dataTable').DataTable().draw();
                }
            });

            $('#dataTable').on('search.dt', function() {
                var value = $('.dataTables_filter input').val();
                var s = $('#filter:text').val(value);
                $('#alertdiv').attr('hidden', true);
                $("#alertdata").empty();
            });

            $('#addcomment').click(function(e) {
                e.preventDefault();
                var formData = new FormData();
                var commentvalue = $('#commentvalue').val();
                var userstatus = $('#userstatus option:selected').text();
                var checkedrow = table.rows('.selected').data();
                if (checkedrow.length == 0) {
                    $('#alertdiv').attr('hidden', true);
                    $("#alertdata").empty();
                    $("#alertdata").append(
                        "<div class= 'alert alert-danger'>" + "You should select data" +
                        "</div>");
                    $("#alertdata").attr('hidden', false);
                } else if (checkedrow.length == 1) {
                    formData.append("_token", "{{ csrf_token() }}");
                    formData.append('comment', commentvalue);
                    formData.append('userstatus', userstatus);
                    formData.append('checkedrow', checkedrow[0].dataid);
                    formData.append('appointment_date', $('#datetimepicker').val());
                    $.ajax({
                        method: 'post',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        enctype: 'multipart/form-data',
                        url: "{{ route('add_comment') }}",
                        success: function(result) {
                            $("#alertdata").empty();
                            $("#alertdata").append("<div class= 'alert alert-success'>" + result
                                .message +
                                "</div>");
                            $("#alertdata").attr('hidden', false);
                            $('#commentvalue').val("");
                            $('#dataTable').data("dt_params", {
                                _token: "{{ csrf_token() }}",
                                "emirates": $('.filter1').val(),
                                "area": $('.filter').val(),
                                "residence": $('.filter2').val(),
                                "startdate": $('#startdate').val(),
                                "enddate": $('#enddate').val(),
                                'searchday': $('#daymonthvalue').val(),
                                'filtertype': $('#filtertype').val()
                            }, );
                            $('#dataTable').DataTable().draw();
                        },
                        error: function(error) {
                            $("#alertdata").empty();
                            $.each(error.responseJSON.errors, function(index, value) {
                                $("#alertdata").append(
                                    "<div class= 'alert alert-danger'>" +
                                    index +
                                    "   " + value + "</div>");
                            });
                            $("#alertdata").attr('hidden', false);
                        }
                    });
                } else {
                    $('#alertdiv').attr('hidden', true);
                    $("#alertdata").empty();
                    $("#alertdata").append(
                        "<div class= 'alert alert-danger'>" + "You should select only one data" +
                        "</div>");
                    $("#alertdata").attr('hidden', false);
                }

            });

            $('#userstatus').change(function(e) {
                e.preventDefault();
                if (this.value == "Set appointment") {
                    openForm();
                } else
                    closeForm();
            });
        });
    </script>


    <!-- jQuery library -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    {{-- open form --}}
    <script>
        function openForm() {
            document.getElementById("popupForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("popupForm").style.display = "none";
        }
    </script>

    <script>
        $(document).ready(function() {

            $('div#emirates').show();
            $('div#usage').hide();
            $('div#nationality').hide();

        });
    </script>

    <script>
        $(document).bind("contextmenu", function(e) {
            return false;
        });

        $(document).keydown(function(event) {
            $("#alertdata").attr('hidden', true);
            $("#alertdata").empty();
            if (event.ctrlKey == true && (event.which == '118' || event.which == '86' || event.which == '67' ||
                    event.which == '88')) {
                $("#alertdata").attr('hidden', false);
                $("#alertdata").append(
                    "<div class= 'alert alert-danger'> you cannot copy paste move </div>");
                event.preventDefault();
            }
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>

@endpush
