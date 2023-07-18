@extends('layouts.app')

@push('head')
    <title>Assign agent to qualified data</title>

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
                            Assign agent to qualified data
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

                                <div class="row mb-1">
                                    <div class="col-md-3">
                                        Agent name
                                    </div>
                                </div>
                                <div class="row mb-5">

                                    <div class="col-md-3">
                                        <select id="userid" class="form-control">
                                            <option value="">Agent name</option>
                                            @foreach ($agentnames as $agentname)
                                                <option value="{{ $agentname->id }}">{{ ucfirst($agentname->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- <div class="col-md-3">
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
                                    </div> --}}

                                </div>

                                <h3 class="ml-4">Filter data</h3>
                                <div class="row mt-4 mb-5">
                                    {{-- <div class="col-md-4">
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
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <h4>Data source</h4>
                                        </div>
                                        <select id="datasource" class="form-control mt-2">
                                            <option value="">All</option>
                                            @foreach ($datasources as $datasource)
                                                <option value="{{ $datasource->source }}">
                                                    {{ ucfirst($datasource->source) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <thead style="background: #70cacc;color: aliceblue;">
                                    <tr>
                                        <th>check</th>
                                        <th>Name</th>
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
                "url": "{{ route('search_for_agent_qualified_data') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    return $.extend({}, d, {
                        _token: "{{ csrf_token() }}",
                        "userid": $('#userid').val(),
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
            "columns": [{
                    data: "check",
                    width: '150px'
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
                    "userid": $('#userid').val(),
                    "agentname": $('#agentname').val(),
                    "datasource": $('#datasource').val()
                }, );
                $('#dataTable').DataTable().draw();

                // get assigned data info
                // $.ajax({
                //     url: "{{ route('get_assigned_user_data_info') }}",
                //     dataType: "json",
                //     type: "POST",
                //     data: {
                //         _token: "{{ csrf_token() }}",
                //         "userid": $('#userid').val()
                //     },
                //     success: function(result) {
                //         $("#commenteddatacount").text(result.commenteddatacount);
                //         $("#assigneddatacount").text(result.assigneddatacount);
                //         userindex = $('#userid')[0].selectedIndex;
                //         if (userindex == 0) {
                //             $('#div1').attr('hidden', true);
                //             $('#div2').attr('hidden', true);
                //         } else {
                //             $('#div1').attr('hidden', false);
                //             $('#div2').attr('hidden', false);
                //         }
                //     }
                // })
            });

            $('#agentname').change(function() {
                $("#alertdata").empty();
                $('#dataTable').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "userid": $('#userid').val(),
                    "agentname": $('#agentname').val(),
                    "datasource": $('#datasource').val()
                }, );
                $('#dataTable').DataTable().draw();
            });

            $('#datasource').change(function() {
                $("#alertdata").empty();
                $('#dataTable').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "userid": $('#userid').val(),
                    "datasource": $('#datasource').val(),
                    "agentname": $('#agentname').val()
                }, );
                $('#dataTable').DataTable().draw();
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
                    url: "{{ route('assign_agent_qualified_data') }}",
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
                                "userid": $('#userid').val(),
                                "datasource": $('#datasource').val(),
                                "agentname": $('#agentname').val()
                            }, );
                            $('#dataTable').DataTable().draw();

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
