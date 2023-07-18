@extends('layouts.app')

@push('head')
    <title>Qualified leads</title>

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

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.css"
        crossorigin="anonymous" />


    <!--datatable-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css" />


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
            <div class="container-fluid" style="margin-top:2.5rem">

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800"></h1>
                <span id="alertdata"></span>
                <div class="alert alert-danger pb-3 mt-3" role="alert" id="alertdiv" hidden></div>
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h3 class="m-0 font-weight-bold" style="color: #70cacc;">
                            Qualified leads
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
                    <div class="card-bod" style="width: 96%; margin-left: 2%">

                        <div class="row mt-4 mb-5 ml-5">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <h4>Agent name</h4>
                                </div>
                                <select id="agentname" class="form-control mt-2">
                                    <option value="">All</option>
                                    @foreach ($agentnames as $agentname)
                                        <option value="{{ $agentname->id }}">{{ ucfirst($agentname->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <h4>Data source</h4>
                                </div>
                                <select id="datasource" class="form-control mt-2">
                                    <option value="">All</option>
                                    @foreach ($datasources as $datasource)
                                        <option value="{{ $datasource->source }}">{{ ucfirst($datasource->source) }}
                                        </option>
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
                        <div class="card-body mt-3">
                            <table class="table table-bordered table-hover" style="width: 200%" id="bookslist">
                                <thead style="background: #70cacc;color: aliceblue;">
                                    <tr>
                                        <th>Check</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Title</th>
                                        <th>Bedroom</th>
                                        <th>Project</th>
                                        <th>Source</th>
                                        <th>Agent name</th>
                                        <th>Created at</th>
                                        <th>Data id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>
                            <div class="row mt-2">
                                <div id="tableinfo" class="col-md-6 d-flex justify-content-start"></div>
                                <div id="tablepaginate" class="col-md-6 d-flex justify-content-end"></div>
                            </div>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.js">
    </script>

    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js">
    </script>

    {{-- swal alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss'
            });
            
            var table = $('#bookslist').DataTable({
                "processing": true,
                "serverSide": true,
                scrollY: 500,
                scrollX: true,
                scrollCollapse: true,
                "pageLength": 25,
                "deferRender": true,
                "paging": true,
                "pagingType": "full_numbers",
                "dom": 'lftip',
                "ajax": {
                    "url": "{{ route('qualified_user_home_data') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        return $.extend({}, d, {
                            _token: "{{ csrf_token() }}",
                            "agentname": $('#agentname').val(),
                            "datasource": $('#datasource').val()
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
                columns: [{
                        data: "check",
                        width: '30px'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        width: 500
                    },
                    {
                        data: 'email',
                        name: 'email',
                        width: 200
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        width: 200
                    },
                    {
                        data: 'title',
                        name: 'title',
                        width: 500
                    },
                    {
                        data: 'number_of_beds',
                        name: 'number_of_beds',
                        width: 100
                    },
                    {
                        data: 'project',
                        name: 'project',
                        width: 200
                    },
                    {
                        data: 'source',
                        name: 'source',
                        width: 200
                    },
                    {
                        data: 'created_by',
                        name: 'created_by',
                        width: 200
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        width: 250
                    },
                    {
                        data: 'dataid',
                        name: 'dataid',
                        width: 150,
                        // visible: false
                    }
                ],
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

            $('#agentname').change(function() {
                $("#alertdata").empty();
                $('#bookslist').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "agentname": $('#agentname').val(),
                    "datasource": $('#datasource').val()
                }, );
                $('#bookslist').DataTable().draw();
            });

            $('#datasource').change(function() {
                $("#alertdata").empty();
                $('#bookslist').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "agentname": $('#agentname').val(),
                    "datasource": $('#datasource').val()
                }, );
                $('#bookslist').DataTable().draw();
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
                        url: "{{ route('add_qualified_comment') }}",
                        success: function(result) {
                            $("#alertdata").empty();
                            $("#alertdata").append("<div class= 'alert alert-success'>" + result
                                .message +
                                "</div>");
                            $("#alertdata").attr('hidden', false);
                            $('#commentvalue').val("");
                            $('#bookslist').data("dt_params", {
                                _token: "{{ csrf_token() }}",
                                "agentname": $('#agentname').val(),
                                "datasource": $('#datasource').val()
                            }, );
                            $('#bookslist').DataTable().draw();
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

    {{-- open form --}}
    <script>
        function openForm() {
            document.getElementById("popupForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("popupForm").style.display = "none";
        }
    </script>

@endpush
