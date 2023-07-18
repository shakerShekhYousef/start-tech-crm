@extends('layouts.app')
@push('head')
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <title>Import</title>

    <!-- Custom styles for this page -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.semanticui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="images/css/dash.css">

@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <h1 style="margin: auto" class="mt-4 mb-4 pt-5">Import Excel File</h1>

        <div style="width: 70%;margin: +2rem auto auto auto;">


            <span id="field_errors"></span>

            {{-- submit form --}}
            <form id="uploadForm" method="POST">
                @csrf

                <div class="alert alert-success pb-3 mt-3" role="alert" id="alertdiv" hidden></div>
                <input type="file" name="uploadFile" id="uploadFile" class="form-control" onchange="uploadFile1()">

                <div class="progress">
                    <div id="upload-progress-bar" class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0"
                        aria-valuemax="100" style="width: 0%">
                        0%
                    </div>
                </div>
                <br />
                <h3 id="status"></h3>
                <p id="loaded_n_total"></p>
                <br>

            </form>

            {{-- import form --}}
            <form id="importForm" action="{{ url('/import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div id="startproccess">
                    <div class="row">
                        <div class="col-md-8">
                            <h1>We are importing your data now</h1>
                            <h3> You can leave this page and you will receive an email when the process is
                                completed.
                            </h3>
                            <h5>Thanks</h5>
                        </div>
                        <div class="col-md-4">
                            <img src="{{ asset('img/logoemail1.JPG') }}" width="200" height="200" alt="">
                        </div>

                    </div>
                </div>

                <br />
                <div id="success">
                </div>

                <button type="submit" id="import" onclick="stratImport()" name="save" class="btn btn-primary btn-block"
                    style="background: #70cacc">Import</button>
                <br>
                <br>
                <a class="btn btn-primary" style="background: #70cacc"
                    href="{{ url('template/template.xlsx') }}">Download Template</a><span></span>

            </form>
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

    {{-- upload process --}}
    <script>
        function _(el) {
            return document.getElementById(el);
        }

        function uploadFile1() {
            $('#alertdiv').attr('hidden', true);
            $("#field_errors").empty();
            var file = _("uploadFile").files[0];
            var formdata = new FormData();
            formdata.append("uploadFile", file);
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "file_upload_parser.php");
            ajax.send(formdata);
        }

        function progressHandler(event) {
            var totalfilesize = parseInt(event.total) / (1024 * 1024);
            var fileinprogress = parseInt(event.loaded) / (1024 * 1024);
            _("loaded_n_total").innerHTML = "Uploaded " + fileinprogress.toFixed(2) + " Mbytes of " + totalfilesize
                .toFixed(2);
            var percent = (event.loaded / event.total) * 100;
            $('#upload-progress-bar').css('width', parseInt(percent) + '%');
            $('#upload-progress-bar').text(parseInt(percent) + '%');
            _("status").innerHTML = "Uploading... please wait";
        }

        function completeHandler(event) {
            _("status").innerHTML = event.target.responseText;
            $('#upload-progress-bar').css('width', 100 + '%');
        }

        function errorHandler(event) {
            _("status").innerHTML = "Upload Failed";
        }

        function abortHandler(event) {
            _("status").innerHTML = "Upload Aborted";
        }
    </script>

    {{-- filter data --}}
    <script>
        $(".filter").change(function() {
            var filterValue = $(this).val();
            if (filterValue != 'Show') {
                var row = $('.ro');

                row.hide()
                row.each(function(i, el) {
                    if ($(el).attr('data-type') == filterValue) {
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>

    <script>
        function stratImport() {
            $('#startproccess').prop('hidden', false);
            var file_data = $('#uploadFile').prop('files')[0];
            var form_data = new FormData();
            form_data.append('_token', "{{ csrf_token() }}");
            form_data.append('file', file_data);
            $.ajax({
                url: 'import',
                type: 'POST',
                async: false,
                contentType: false,
                processData: false,
                dataType: 'JSON',
                data: form_data,
                success: function(val) {
                    if (val.success == "true") {
                        $('#uploadFile').prop('disabled', false);
                        $('#import').prop('disabled', false);
                        $('#upload-progress-bar').text('0%');
                        $('#upload-progress-bar').css('width', 0);
                        $('#uploadFile').val('');
                        _("status").innerHTML = "";
                        _("loaded_n_total").innerHTML = "";
                        $("#field_errors").attr('hidden', false);
                        $("#field_errors").append(
                            "<ul class='alert alert-success'>" +
                            val.message + "</ul>")
                        $('#startproccess').prop('hidden', true);
                    } else {
                        $("#field_errors").append(
                            "<ul class='alert alert-danger'>" +
                            val.message + "</ul>")
                        $('#startproccess').prop('hidden', true);

                        $('#import').prop('disabled', false);
                        $('#uploadFile').prop('disabled', false);
                        $('#alertdiv').attr('hidden', true);
                        $("#field_errors").attr('hidden', false);
                    }
                },
                error: function(val) {
                    if (val.responseJSON.message.includes('getClientOriginalExtension')) {
                        $("#field_errors").append(
                            "<ul class='alert alert-danger'>" +
                            'you should select valid csv file only' + "</ul>")
                    } else {
                        $("#field_errors").append(
                            "<ul class='alert alert-danger'>" +
                            val.message + "</ul>")
                    }

                    $('#startproccess').prop('hidden', true);

                    $('#import').prop('disabled', false);
                    $('#uploadFile').prop('disabled', false);
                    $('#alertdiv').attr('hidden', true);
                    $("#field_errors").attr('hidden', false);
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            if ({{ Auth::user()->getcurrentproccessstatus() }} == 0) {
                $('#startproccess').prop('hidden', false);
                $("#field_errors").empty();
                $('#import').prop('disabled', true);
                $('#uploadFile').prop('disabled', true);
            } else {
                $('#startproccess').prop('hidden', true);
                $("#field_errors").empty();
                $('#import').prop('disabled', false);
                $('#uploadFile').prop('disabled', false);
            }
            $('#importForm').submit(function(e) {
                e.preventDefault();
                $("#field_errors").empty();
                $('#import').prop('disabled', true);
                $('#uploadFile').prop('disabled', true);

            });
        })
    </script>

@endpush
