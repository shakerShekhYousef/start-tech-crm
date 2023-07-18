@extends('layouts.app')
@push('head')

    <title>Show follow up leads data comments</title>

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

    <!--datatable-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css" />

    <!--datatable-->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.css"
        crossorigin="anonymous" />

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
                            Show follow up leads data comments
                        </h3>

                        <span id="alertdata"></span>

                        <div class="alert pb-3 mt-3" role="alert" id="alertdiv" hidden>
                        </div>

                        <input value="" type="text" name="search" id="filter" hidden />
                        <div class="row mt-5 mb-5">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <h4>Customer status</h4>
                                </div>
                                <select id="userstatus" class="form-control mt-2">
                                    <option value="">All</option>
                                    @foreach ($userstatus as $state)
                                        <option value="{{ $state }}">{{ ucfirst($state) }}
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
                        <table class="table table-bordered table-hover" style="width: 250%" id="dataTable">
                            <thead style="background: #70cacc;color: aliceblue;">
                                <tr>
                                    <th>Name</th>
                                    <th>Commnets</th>
                                    <th>User status</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Title</th>
                                    <th>Bedroom</th>
                                    <th>Project</th>
                                    <th>Source</th>
                                    <th>Agent name</th>
                                    <th>Created at</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

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
                                <div class="card-body" style="color: black;background-color: #FEFEE7">
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

    {{-- swal alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {

            function getcommentsinfo() {
                // get comments data
                $.ajax({
                    url: "{{ route('get_follow_up_data_comments_info') }}",
                    dataType: "json",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        "userstatus": $('#userstatus').val(),
                        "datasource": $('#datasource').val()
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
                    "url": "{{ route('show_follow_up_data_comments') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        return $.extend({}, d, {
                            _token: "{{ csrf_token() }}",
                            "userstatus": $('#userstatus').val(),
                            "datasource": $('#datasource').val()
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
                    },
                    error: function(res) {
                        console.log(res);
                    },
                },
                "columns": [{
                        data: 'name',
                        name: 'name',
                        width: 300
                    },
                    {
                        data: 'comments',
                        name: 'comments',
                        width: 400
                    },
                    {
                        data: 'userstatus',
                        name: 'userstatus',
                        width: 400
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
                    }
                ],
                "lengthMenu": [
                    [100, 500, 1000],
                    [100, 500, 1000]
                ],
                "dom": 'Blftip',
                "buttons": [{
                        "extend": 'excel'
                    },
                    {
                        "extend": 'csv',
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
            $("div.dataTables_filter input").unbind();
            $("div.dataTables_filter input").keyup(function(e) {
                if (e.keyCode == 13) {
                    table.search(this.value).draw();
                }
            });

            $('#userstatus').change(function() {
                $("#alertdata").empty();
                $('#dataTable').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "userstatus": $('#userstatus').val(),
                    "datasource": $('#datasource').val()
                }, );
                $('#dataTable').DataTable().draw();
            });

            $('#datasource').change(function() {
                $("#alertdata").empty();
                $('#dataTable').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "userstatus": $('#userstatus').val(),
                    "datasource": $('#datasource').val()
                }, );
                $('#dataTable').DataTable().draw();
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
