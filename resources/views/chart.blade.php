@extends('layouts.app')

@push('head')
    <title>Charts</title>

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


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>

@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <div id="charts" style="width:70%;margin: 5rem auto auto auto">
            <p>Visualization</p>
            <select class="form-control filter">
                <option value="emirates">Emirates</option>
                <option value="nationality">Nationality</option>
                <option value="usage">Usage</option>
            </select>
        </div>

        <div id="emirates" data-type="emirates" class="data">
            <div class="container text-center"> <br>
                <h1 class="mt-5">Emirate</h1> <br>
                {!! $chart->container() !!}
            </div>
            <hr>
            <div class="container text-center"> <br>
                {!! $chart1->container() !!}
            </div>
        </div>

        <div id="nationality" data-type="nationality" class="data">
            <div class="container text-center"> <br>
                <h1 class="mt-5">Nationality</h1> <br>
                {!! $chart2->container() !!}
            </div>
            <hr>
            <div class="container text-center"> <br>
                {!! $chart3->container() !!}
            </div>
        </div>

        <div id="usage" data-type="usage" class="data">
            <div class="container text-center"> <br>
                <h1 class="mt-5">USAGE</h1> <br>
                {!! $chart4->container() !!}
            </div>
            <hr>
            <div class="container text-center"> <br>
                {!! $chart5->container() !!}
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
    <script src="js/demo/datatables-demo.js"></script>
    <script>
        $(document).ready(function() {

            $('select.custom-select').val($('select.custom-select > option:last').val()).change();

        });
    </script>

    <!-- jQuery library -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="{{ $chart->cdn() }}"></script>
    <script src="{{ $chart1->cdn() }}"></script>
    <script src="{{ $chart2->cdn() }}"></script>
    <script src="{{ $chart3->cdn() }}"></script>
    <script src="{{ $chart4->cdn() }}"></script>
    <script src="{{ $chart5->cdn() }}"></script>
    {{ $chart->script() }}
    {{ $chart1->script() }}
    {{ $chart2->script() }}
    {{ $chart3->script() }}
    {{ $chart4->script() }}
    {{ $chart5->script() }}

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
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>

@endpush