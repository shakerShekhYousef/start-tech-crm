@extends('layouts.app')

@push('head')
    <title>Assign agents for landing page</title>

    <!-- Custom fonts for this template -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.semanticui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="images/css/dash.css">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: white;
        }

        * {
            box-sizing: border-box;
        }

        /* Add padding to containers */
        .container {
            padding: 16px;
            background-color: white;
        }

        /* Full-width input fields */
        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }

        input[type=text]:focus,
        input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        /* Overwrite default styles of hr */
        hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 25px;
        }

        /* Set a style for the submit button */
        .registerbtn {
            background-color: #70cacc;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            width: 10%;
            opacity: 0.9;
        }

        .center {
            margin: 0 100 0 0;
            position: absolute;
            left: 50%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
        }

        .registerbtn:hover {
            opacity: 1;
        }

        /* Add a blue text color to links */
        a {
            color: dodgerblue;
        }

        /* Set a grey background color and center the text of the "sign in" section */
        .signin {
            background-color: #f1f1f1;
            text-align: center;
        }

    </style>


    {{-- swal alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <h3 style="margin: auto" class="mt-4 mb-4">Assign agent for landing page</h3>
        <form id="maindata">
            <div class="container">
                <span id="alertdata"></span>

                <select name="landingname" class="form-control filter mt-2" style="height:40px" id="landingname"
                    style="font-size:.7rem;font-weight:bold">
                    <option selected value="">Landing page</option>
                    @foreach ($campaigns as $campaign)
                        <option value="{{ $campaign->id }}">{{ ucfirst($campaign->name) }}</option>
                    @endforeach
                </select>

                <select name="agent" class="form-control filter mt-5" style="height:40px" id="agent"
                    style="font-size:.7rem;font-weight:bold">
                    <option selected value="">Agent name</option>
                    @foreach ($agents as $agent)
                        <option value="{{ $agent->id }}">{{ ucfirst($agent->name) }}</option>
                    @endforeach
                </select>

                <hr>

                <button id="buttonsubmit" type="button" class="registerbtn center">Assign</button>
            </div>
        </form>

        <div class="card-body mt-3" style="width: 90%; margin-left: 5%">
            <table class="table table-bordered table-hover" style="width: 100%" id="dataTable">
                <thead style="background: #70cacc;color: aliceblue;">
                    <tr>
                        <th>id</th>
                        <th>Agent email</th>
                        <th>Landing page</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="table-responsive mt-5" style="max-height:278vh;overflow:scroll; width: 90%; margin-left: 5%">
            </div>
        </div>

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
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script>
        $(document).ready(function() {

            $('select.custom-select').val($('select.custom-select > option:last').val()).change();

        });
    </script>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    <!--datatable-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.js">
    </script>

    <script>
        $('#buttonsubmit').click(function(e) {
            e.preventDefault();
            var formData = new FormData();

            $('#maindata').serializeArray().forEach(function(field) {
                formData.append(field.name, field.value);
            });

            formData.append("_token", "{{ csrf_token() }}");

            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                enctype: 'multipart/form-data',
                url: "{{ route('assign_agent_to_landpage') }}",
                success: function(result) {
                    console.log(result);
                    $("#alertdata").empty();
                    $("#alertdata").append("<div class= 'alert alert-success'>" + result.message +
                        "</div>");
                    $("#alertdata").attr('hidden', false);
                    $("#maindata")[0].reset();
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
                "url": "{{ route('list_assigned_landing_agent') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}",
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
                    data: "agentname",
                    width: '200px'
                },
                {
                    data: "landing_name",
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
            dom: 'lftip',
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
                        url: "{{ route('delete_landing') }}",
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
    </script>

@endpush
