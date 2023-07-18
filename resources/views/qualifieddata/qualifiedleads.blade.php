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

    {{-- swal alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header pt-5">
                        <h3 class="m-0 font-weight-bold" style="color: #70cacc;">
                            Qualified leads
                        </h3>

                    </div>

                    <div class="card-bod" style=" width: 96%; margin-left: 2%">
                        <div class="alert alert-error pb-3 mt-3" role="alert" id="alertdiv" hidden></div>

                        <div class="row mt-4 mb-5">
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
                        <span id="alertdata"></span>
                        @if (Auth::user()->isAdmin() || Auth::user()->isAgent())
                            <div class="row mt-4 mb-2">
                                <div class="col-md-3 d-flex justify-content-start">
                                    <div id="tablebuttoncsv" class="mr-1 ml-3"></div>
                                    <div id="tablebuttonexcel" class="mr-1"></div>
                                    <div id="tablebuttonpdf" class="mr-1"></div>
                                </div>
                            </div>
                        @endif
                        <table class="table table-stripe table-hover" style="width: 300%" id="bookslist">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Title</th>
                                    <th>Bedroom</th>
                                    <th>Project</th>
                                    <th>Source</th>
                                    <th>Agent name</th>
                                    <th>Created at</th>
                                    {{-- <th>Action</th> --}}
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
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!--datatable-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.js">
    </script>

    <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>

    <script src=""></script>

    <script>
        $(document).ready(function() {
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
                "ajax": {
                    "url": "{{ route('qualified_leads') }}",
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
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: 20
                    },
                    {
                        data: 'name',
                        name: 'name',
                        width: 200
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
                        width: 300
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
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     width: 350
                    // },
                ],
                dom: 'lftipB',
                "buttons": [{
                        "extend": 'excel'
                    },
                    {
                        "extend": 'csv'
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
                            url: "{{ route('delete_customer') }}",
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

            // Edit a record
            $('body').on('click', '.edit', function() {
                var id = table.row(this.closest('tr')).data()['id'];

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "Get",
                    url: "{{ route('update_customer_index') }}/" + id,
                    dataType: 'html',
                    success: function(result) {
                        window.location.href = "{{ route('update_customer_index') }}/" +
                            id;
                    },
                    error: function(erorr) {
                        console.log(erorr);
                    }
                });

            });

        });
    </script>

@endpush
