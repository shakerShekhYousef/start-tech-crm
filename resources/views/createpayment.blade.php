@extends('layouts.app')

@push('head')
    <title>Create payment</title>

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

    <!-- jQuery library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js">
    </script>

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

        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;

            padding-right: 20px;
        }

        html .ui-autocomplete {
            height: 200px;
            width: 40%
        }

    </style>
@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <h2 style="margin-left: 30%" class="mt-5 mb-5">Create new payment</h2>
        <form id="maindata" class="mt-5">
            <div class="container">
                <span id="alertdata"></span>

                <div class="row">
                    <div class="col-md-6">
                        <label for="buyerid"><b>Buyer name</b></label>
                        <select name="buyerid" class="form-control filter mt-2" style="height:40px" id="buyerid"
                            style="font-size:.7rem;font-weight:bold">
                            <option selected value="">User name</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="property"><b>Property</b></label>
                        <input type="text" placeholder="Enter Property" name="property" id="property" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="amount"><b>Amount</b></label>
                        <input class="form-control" type="text" placeholder="Enter Payment Amount" name="amount" id="amount" required style="height: 46%;margin-top: 1%">
                    </div>

                    <div class="col-md-6">
                        <label for="Paymentdate"><b>Payment date</b></label>
                        <input type="text" placeholder="Enter Payment Date" name="Paymentdate" id="datetimepicker" required">
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button id="buttonsubmit" type="button" class="registerbtn">Create</button>
                    </div>
                </div>
            </div>
        </form>


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

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('select.custom-select').val($('select.custom-select > option:last').val()).change();
        });
        $('#datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    </script>

    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet"
        type="text/css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>

    <script>
        $('#buttonsubmit').click(function(e) {
            $("#alertdata").empty();
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
                url: "{{ route('create_new_payment') }}",
                success: function(result) {
                    if (result.success) {
                        $("#alertdata").empty();
                        $("#alertdata").append("<div class= 'alert alert-success'>" + result.message +
                            "</div>");
                        $("#alertdata").attr('hidden', false);
                        $("#maindata")[0].reset();
                    } else {
                        $("#alertdata").empty();
                        $("#alertdata").append("<div class= 'alert alert-danger'>" + result.message +
                            "</div>");
                        $("#alertdata").attr('hidden', false);
                    }
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
    </script>

    {{-- add comma for input --}}
    <script>
        $("#amount").blur(function() {
            $("#amount").val(parseFloat($("#amount").val(), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")
                .toString());
        });
    </script>

    <script>
        $(document).ready(function() {
            var properties = {!! $properties !!};
            var users = {!! $users !!};
            $("#property").autocomplete({
                source: properties
            });
        });
    </script>

@endpush
