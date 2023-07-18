@extends('layouts.app')

@push('head')
    <title>Uploaded files</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


    <!-- Custom styles for this page -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.semanticui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="images/css/dash.css">
    <style>
        html {
            scroll-behavior: smooth;
        }

        .alert-success {

            margin: 3px 20px;
            color: #0f6848;
            background-color: #d2f4e8;
            border-color: #bff0de;
        }

    </style>

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
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h3 class="m-0 font-weight-bold" style="color: #70cacc;">
                            Uploaded Files
                            <div class="form-group">

                            </div>
                            <div class="form-group">

                            </div>
                            <div class="form-group">

                            </div>
                        </h3>

                    </div>

                    <div class="card-bod" style="max-height: 80vh;overflow:scroll">
                        <div class="table-responsiv">
                            <div class="form-group pull-right" style="width: 70%;margin:1.5rem auto 0 auto">
                                <input type="text" class="search form-control" placeholder="Search"> <br>
                            </div>
                            <div style="display:none" id="success" class="alert alert-success alert-dismissible fade show"
                                role="alert">
                                <strong>Success</strong> File deleted successfully
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <table class="table table-bordere" style="max-height: 80vh;overflow:scroll" id="dataTabl"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <th>On Date</th>
                                        <th>Rows Count</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $file)
                                        <tr class="ro" data-type="{{ $file->fileName }}">
                                            <td>{{ str_replace('uploadedFiles/', ' ', $file->fileName) }}</td>
                                            <td>{{ $file->created_at }}</td>
                                            <td>{{ $file->numberofimportedrows }}</td>
                                            <td><a class="btn btn-primary"
                                                    href="{{ url('/downloadFile/' . str_replace('uploadedFiles/', '/', $file->fileName)) }}">Download</a>
                                            </td>
                                            <td>
                                                <form class="form" action="{{ route('deleteFile', $file->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <span id="delete">Delete</span>

                                                    </button>


                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>
                            <div class="card-footer py-3">
                                <h3 class="m-0 font-weight-bold" style="color: #2c2d7c;">
                                    <div>Total Rows : {{ $totaRowsCount }}</div>
                                    <div class="form-group">

                                    </div>
                                    <div class="form-group">

                                    </div>
                                    <div class="form-group">

                                    </div>
                                </h3>

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

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-clock-o"></i> Please Wait</h4>
                </div>
                <div class="modal-body center-block">
                    <div style="text-align:center" id='wait' class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span>Please wait until file deleted</span>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script>
        $(document).ready(function() {

            $('select.custom-select').val($('select.custom-select > option:last').val()).change();

        });
    </script>

    <script>
        $(".filter").change(function() {
            var filterValue = $('.filter').val();
            var filterValue1 = $('.filter1').val();
            var filterValue2 = $('.filter2').val();
            if (filterValue != 'Show') {
                var row = $('.ro');

                row.hide()
                row.each(function(i, el) {
                    if ($(el).attr('data-type') == filterValue || $(el).attr('data-typee') ==
                        filterValue1 || $(el).attr('data-typeee') == filterValue2) {
                        $(el).show();
                    }
                })
            } else {
                var row = $('.ro');

                row.hide()
                row.each(function(i, el) {

                    $(el).show();

                })
            }


        });
    </script>

    <!-- jQuery library -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {

            $('.form').ajaxForm({

                beforeSend: function() {


                    $('.btn-danger').prop('disabled', true);

                    $('#myModal').modal('show');



                },

                success: function(data) {

                    location.reload();
                    $('#success').css('display', 'block');
                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {

            $('div#emirates').show();
            $('div#usage').hide();
            $('div#nationality').hide();

        });
        $(".filter").change(function() {
            var filterValue = $(this).val();
            if (filterValue == 'emirates') {
                $('div#emirates').show();
                $('div#usage').hide();
                $('div#nationality').hide();
            }
            if (filterValue == 'usage') {
                $('div#usage').show();
                $('div#emirates').hide();
                $('div#nationality').hide();
            }
            if (filterValue == 'nationality') {
                $('div#nationality').show();
                $('div#emirates').hide();
                $('div#usage').hide();
            }

            // row.each(function(i, el) {
            //      if($(el).attr('data-type') == filterValue) {
            //          $(el).show();
            //      }
            // })



        });
    </script>
    <script>
        $(document).ready(function() {
            $('.search').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                $('#dataTabl tbody tr').each(function() {
                    var lineStr = $(this).text().toLowerCase();
                    if (lineStr.indexOf(searchTerm) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        });
    </script>

@endpush