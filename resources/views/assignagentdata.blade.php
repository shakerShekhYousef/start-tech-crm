@extends('layouts.app')

@push('head')
    <title>Assign agent data</title>

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

        /*Hidden class for adding and removing*/
        .lds-dual-ring.hidden {
            display: none;
        }

        /*Add an overlay to the entire page blocking any further presses to buttons or other elements.*/
        .overlay {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, .8);
            z-index: 999;
            opacity: 1;
            transition: all 0.5s;
        }

        /*Spinner Styles*/
        .lds-dual-ring {
            display: inline-block;
            width: 80px;
            height: 80px;
        }

        .lds-dual-ring:after {
            content: " ";
            display: block;
            width: 64px;
            height: 64px;
            margin: 5% auto;
            border-radius: 50%;
            border: 6px solid #fff;
            border-color: #fff transparent #fff transparent;
            animation: lds-dual-ring 1.2s linear infinite;
        }

        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .disabledbutton {
            pointer-events: none;
            opacity: 0.4;
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
    <script src="https://cdn.datatables.net/scroller/2.0.5/js/dataTables.scroller.min.js"></script>

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

                    <div class="card-header py-3">
                        <h3 class="m-0 font-weight-bold" style="color: #70cacc;">
                            Assign agent data
                        </h3>
                        <div id="loader" class="lds-dual-ring hidden overlay"></div>
                        <div class="alert alert-error pb-3 mt-3" id="alertdata" role="alert" hidden>
                        </div>

                        <div class="alert alert-danger pb-3 mt-3" role="alert" id="alertdiv" hidden>
                        </div>

                    </div>

                    <div class="card-body mt-3">
                        <div class="table-responsive" style="max-height:278vh;overflow:scroll">
                            <table class="table table-bordered table-hover" style="width: 6000px" id="dataTable">

                                {{-- <h3 class="ml-4">Select user</h3> --}}
                                <div class="row mb-5">
                                    <div class="col-md-3">
                                        <select id="userid" class="form-control">
                                            <option value="">Agent name</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                    </div>
                                    <div id="div1" class="col-md-2 bl-0" hidden>
                                        <div class="card text-white bg-primary d-flex justify-content-center"
                                            style="max-width: 12rem;">
                                            <div class="card-header" style="color: black">Total assigned data</div>
                                            <div class="card-body">
                                                <h3 id="assigneddatacount" class="card-text d-flex justify-content-center">
                                                    {{ isset($assigneddatacount) ? $assigneddatacount : 0 }}</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="div2" class="col-md-2 bl-0" hidden>
                                        <div class="card text-white bg-primary d-flex justify-content-center"
                                            style="max-width: 14rem;">
                                            <div class="card-header" style="color: black">Total commented data</div>
                                            <div class="card-body">
                                                <h3 id="commenteddatacount" class="card-text d-flex justify-content-center">
                                                    {{ isset($commenteddatacount) ? $commenteddatacount : 0 }}</h3>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <h3 class="ml-4">Filter data</h3>
                                <div class="row">
                                    <label for="tfoot3" class="col-md-2 d-flex justify-content-center">
                                        Area
                                    </label>
                                    <label for="tfoot7" class="col-md-2 d-flex justify-content-center">
                                        Emirate
                                    </label>
                                    <label for="tfoot10" class="col-md-2 d-flex justify-content-center">
                                        Address
                                    </label>
                                    <label for="tfoot28" class="col-md-2 d-flex justify-content-center">
                                        Residence country
                                    </label>
                                    <label for="tfoot29" class="col-md-2 d-flex justify-content-center">
                                        Nationality
                                    </label>
                                </div>
                                <div class="row mb-5">
                                    <div id="tfoot3" class="col-md-2">
                                        <select id="areafilter" class="form-control">
                                            <option value="">AREA</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->AREA }}">{{ $area->AREA }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="tfoot7" class="col-md-2">
                                        <select id="emiratefilter" class="form-control">
                                            <option value="">EMIRATE</option>
                                            @foreach ($emirates as $emirate)
                                                <option value="{{ $emirate->EMIRATE }}">
                                                    {{ $emirate->EMIRATE }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="tfoot10" class="col-md-2">
                                        <select id="addresfilter" class="form-control">
                                            <option value="">ADDRESS</option>
                                            @foreach ($address as $addres)
                                                <option value="{{ $addres->ADDRESS }}">{{ $addres->ADDRESS }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="tfoot28" class="col-md-2">
                                        <select id="residencecountryfilter" class="form-control">
                                            <option value="">RESIDENCE COUNTRY</option>
                                            @foreach ($residencecountries as $residencecountry)
                                                <option value="{{ $residencecountry->RESIDENCE_COUNTRY }}">
                                                    {{ $residencecountry->RESIDENCE_COUNTRY }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="tfoot29" class="col-md-2">
                                        <select id="nationalityfilter" class="form-control">
                                            <option value="">NATIONALITY</option>
                                            @foreach ($nationalities as $nationality)
                                                <option value="{{ $nationality->NATIONALITY }}">
                                                    {{ $nationality->NATIONALITY }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <thead style="background: #70cacc;color: aliceblue;">
                                    <tr>
                                        <th>check</th>
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
                "url": "{{ route('serach_for_agent_data') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    return $.extend({}, d, {
                        _token: "{{ csrf_token() }}",
                        "userid": $('#userid').val()
                    });
                },
                beforeSend: function() {
                    $('#loader').removeClass('hidden')
                    $("#parent").addClass("disabledbutton");
                },
                complete: function() {
                    $('#loader').addClass('hidden')
                    $("#parent").removeClass("disabledbutton");
                }
            },
            "columns": [{
                    data: "check",
                    width: '150px'
                },
                {
                    data: "unique",
                    width: '100px'
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
                }
            ],
            "lengthMenu": [
                [100, 500, 1000, 2000, 5000, 10000],
                [100, 500, 1000, 2000, 5000, 10000]
            ],
            "dom": 'Bfltip',
            "buttons": [
                'selectAll',
                'selectNone',
                {
                    text: '<span class="fa fa-plus-circle" aria-hidden="true"></span> Assign',
                    attr: {
                        id: 'assign_data',
                        class: "btn btn-primary"
                    }
                }
            ],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            initComplete: function() {
                $('#tablepaginate').empty();
                $('#dataTable_paginate').appendTo('#tablepaginate');
                $('#tableinfo').empty();
                $('#dataTable_info').appendTo('#tableinfo');
            }
        });
        $(document).ready(function() {

            $('#userid').change(function() {
                $("#alertdata").empty();
                $('#dataTable').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "userid": $('#userid').val()
                }, );
                $('#dataTable').DataTable().draw();

                // get assigned data info
                $.ajax({
                    url: "{{ route('get_assigned_user_data_info') }}",
                    dataType: "json",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        "userid": $('#userid').val()
                    },
                    success: function(result) {
                        $("#commenteddatacount").text(result.commenteddatacount);
                        $("#assigneddatacount").text(result.assigneddatacount);
                        userindex = $('#userid')[0].selectedIndex;
                        if (userindex == 0) {
                            $('#div1').attr('hidden', true);
                            $('#div2').attr('hidden', true);
                        } else {
                            $('#div1').attr('hidden', false);
                            $('#div2').attr('hidden', false);
                        }
                    }
                })
            });

            $('#areafilter').change(function() {
                var selectedValue = $(this).val();
                table.columns(3).search(selectedValue).draw();
            });

            $('#emiratefilter').change(function() {
                var selectedValue = $(this).val();
                table.columns(7).search(selectedValue).draw();
            });

            $('#addresfilter').change(function() {
                var selectedValue = $(this).val();
                table.columns(10).search(selectedValue).draw();
            });

            $('#residencecountryfilter').change(function() {
                var selectedValue = $(this).val();
                table.columns(28).search(selectedValue).draw();
            });

            $('#nationalityfilter').change(function() {
                var selectedValue = $(this).val();
                table.columns(29).search(selectedValue).draw();
            });

            $('#assign_data').click(function(e) {
                $("#alertdata").empty();
                e.preventDefault();
                var data = [];

                var checked_rows = table.rows('.selected').data();
                $.each(checked_rows, function(index, rowId) {
                    data.push(rowId.id);
                });
                var userid = $('#userid').val();

                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("userid", userid);
                if (data.length > 0)
                    formData.append("data", JSON.stringify(data));

                $.ajax({
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    enctype: 'multipart/form-data',
                    url: "{{ route('assign_agent_data') }}",
                    beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                        $('#loader').removeClass('hidden')
                        $("#parent").addClass("disabledbutton");
                    },
                    success: function(result) {
                        if (result.success) {
                            $("#alertdata").empty();
                            $("#alertdata").append("<div class= 'alert alert-success'>" + result
                                .message + "</div>");
                            $("#alertdata").attr('hidden', false);

                            // reload data
                            $('#dataTable').data("dt_params", {
                                _token: "{{ csrf_token() }}",
                                "userid": $('#userid').val()
                            }, );
                            $('#dataTable').DataTable().draw();

                            // $('#loader').addClass('hidden')
                            // $("#parent").removeClass("disabledbutton");
                        } else if (result.message == "There are some duplicated data") {
                            $("#alertdata").empty();
                            $("#alertdata").append("<div class= 'alert alert-danger'>" + result
                                .message +
                                "<a target='_blank' href={{ route('get_assigned_data_index') }}> show data</a>" +
                                "</div>");
                            $("#alertdata").attr('hidden', false);
                            $('#loader').addClass('hidden')
                            $("#parent").removeClass("disabledbutton");
                        } else {
                            $("#alertdata").empty();
                            $("#alertdata").append("<div class= 'alert alert-danger'>" + result
                                .message + "</div>");
                            $("#alertdata").attr('hidden', false);
                            $('#loader').addClass('hidden')
                            $("#parent").removeClass("disabledbutton");
                        }

                        table.rows().deselect();
                        $("th.select-checkbox").removeClass("selected");
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
                        $("#parent").removeClass("disabledbutton");
                        $('#loader').addClass('hidden');
                    }
                });
            });

        });
    </script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

@endpush
