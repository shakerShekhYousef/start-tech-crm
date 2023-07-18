@extends('layouts.app')

@push('head')
    <title>Create inventory</title>

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

    <!-- Autocomplete -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

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

        <h3 style="margin: auto" class="mt-4 mb-4">Create inventory</h3>
        <form id="maindata">
            <div class="container">
                <span id="alertdata"></span>
                <div class=" ml-3 mt-3">
                    <div class="row">
                        <label for="customerenquiry">
                            <h3>Import from csv file</h3>
                        </label>
                    </div>
                    <div class="row">
                        <input type="file" id="file" name="file" class="mb-5">
                    </div>
                    <div class="row">
                        <input type="button" id="import" class="btn btn-md btn-success mt-0 mb-5"
                            style="background-color: #70cacc;color: white;" value="Import">
                        <input type="button" id="file" name="file" class="btn btn-md btn-success ml-4 mb-5"
                            style="background-color: #70cacc;color: white;" value="Template"
                            onclick="location.href='{{ url('public/template/inventory.csv') }}'">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <input type="text" placeholder="Serial Number" name="serial_num" id="serial_num" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Date Listed" name="date_listed" id="date_listed" required>
                    </div>
                    @if (Auth::user()->isadmin())
                        <div class="col-md-4">
                            <input type="text" placeholder="Agent Name" name="agent_name" id="agent_name" required>
                        </div>
                    @else
                        <div class="col-md-4">
                            <input type="text" placeholder="Agent Name" value="{{ Auth::user()->name }}" name="agent_name" id="agent_name" readonly>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <select class="form-control" name="category" id="category" style="height: 62%; margin-top: 1%">
                            <option value="">Category</option>
                            <option value="residential">Residential for sale</option>
                            <option value="buyer">Buyer</option>
                            <option value="residential for rent">Residential for rent</option>
                            <option value="land">Land</option>
                            <option value="commercial">Commercial</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="building_status" id="building_status"
                            style="height: 62%; margin-top: 1%">
                            <option value="">Building Status</option>
                            <option value="ready">Ready</option>
                            <option value="off-plan">Off-plan</option>
                            <option value="near completion">Near completion</option>
                            <option value="secondary">Secondary</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Building Status" name="building_status" id="building_status"
                            required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" placeholder="Client Name" name="client_name" id="client_name" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Unit For Sales" name="unit_for_sales" id="unit_for_sales" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Unit Number" name="unit_number" id="unit_number" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" placeholder="Community Location" name="community_location"
                            id="community_location" required>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="property_type" id="property_type"
                            style="height: 62%; margin-top: 1%">
                            <option value="">Property type</option>
                            @foreach ($propertytype as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="bedrooms" id="bedrooms" style="height: 62%; margin-top: 1%">
                            <option value="">Bedrooms</option>
                            <option value="studio">Studio</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8+">8+</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" placeholder="Specifications/View" name="specifications" id="specifications"
                            required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Property Size" name="property_size" id="property_size" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Price Aed" name="price_aed" id="price_aed" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" placeholder="Remarks" name="remarks" id="remarks" required>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="source_of_lead" id="source_of_lead"
                            style="height: 62%; margin-top: 1%">
                            <option value="">Source of lead</option>
                            <option value="direct">Direct</option>
                            <option value="website">Website</option>
                            <option value="internal leads">Internal leads</option>
                            <option value="sms">Sms</option>
                            <option value="facebook">Facebook</option>
                            <option value="instagram">Instagram</option>
                            <option value="linkedin">Linkedin</option>
                            <option value="marketing">Marketing</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Developer" name="developer" id="developer" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" placeholder="Building Name" name="building_name" id="building_name" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Property Name" name="property_name" id="property_name" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Plot Area" name="plot_area" id="plot_area" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" placeholder="Customer Name" name="customer_name" id="customer_name" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Email Address" name="email_address" id="email_address" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Mobile" name="mobile" id="mobile" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" placeholder="Comments" name="comments" id="comments" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Nationality" name="nationality" id="nationality" required>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="furniture" id="furniture" style="height: 62%; margin-top: 1%">
                            <option value="">Furniture</option>
                            <option value="none">None</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <select class="form-control" name="customer_type" id="customer_type"
                            style="height: 62%; margin-top: 1%">
                            <option value="">Customer type</option>
                            <option value="seller">Seller</option>
                            <option value="buyer">Buyer</option>
                            <option value="rent">Rent</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Can Add" name="can_add" id="can_add" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Roi" name="roi" id="roi" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" placeholder="Telephone Number" name="telephone_number" id="telephone_number"
                            required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Telephone Residence" name="telephone_residence"
                            id="telephone_residence" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Telephone Office" name="telephone_office" id="telephone_office"
                            required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" placeholder="General" name="general" id="general" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Property Finder Link" name="property_finder_link"
                            id="property_finder_link" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Buyut Link" name="buyut_link" id="buyut_link" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" placeholder="Dubizzle Link" name="dubizzle_link" id="dubizzle_link" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Wow Propties Link" name="wow_propties_link" id="wow_propties_link"
                            required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Other Links" name="other_links" id="other_links" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" placeholder="Floors" name="floors" id="floors" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Service Charge" name="service_charge" id="service_charge" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Payment Plan" name="payment_plan" id="payment_plan" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" placeholder="Rent" name="rent" id="rent" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Ready Off" name="ready_off" id="ready_off" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Handover" name="handover" id="handover" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" placeholder="Bathrooms" name="bathrooms" id="bathrooms" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="Completion" name="completion" id="completion" required>
                    </div>
                    <div class="col-md-4">
                        <select name="statuss" id="status" class="form-control" style="height: 62%; margin-top: 1%">
                            <option value="">Customer status</option>
                            @foreach ($status as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="floor_plans_view"> Floor plan/view</label>
                        <input type="file" placeholder="Floor Plans/View" name="floor_plans_view" id="floor_plans_view"
                            required>
                    </div>
                </div>

                <hr>

                <button id="buttonsubmit" type="button" class="registerbtn center">Create</button>
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
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

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

    <!-- Autocomplete -->
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script>
        $('#buttonsubmit').click(function(e) {
            e.preventDefault();
            var formData = new FormData();

            $('#maindata').serializeArray().forEach(function(field) {
                formData.append(field.name, field.value);
            });

            floor_plans_view = $('#floor_plans_view').prop('files')[0];
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("floor_plans_view", floor_plans_view);

            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                enctype: 'multipart/form-data',
                url: "{{ route('create_new_inventory') }}",
                success: function(result) {
                    $("#alertdata").empty();
                    $("#alertdata").append("<div class= 'alert alert-success'>" + result.message +
                        "</div>");
                    $("#alertdata").attr('hidden', false);
                    $("#maindata")[0].reset();
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

        $('#import').click(function(e) {
            $("#alertdata").empty();
            e.preventDefault();
            var file_data = $('#file').prop('files')[0];
            var form_data = new FormData();
            form_data.append('_token', "{{ csrf_token() }}");
            form_data.append('file', file_data);
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: form_data,
                enctype: 'multipart/form-data',
                url: "{{ route('import_inventory') }}",
                success: function(result) {
                    if (result.success) {
                        $("#alertdata").empty();
                        $("#alertdata").append("<div class= 'alert alert-success'>" + result.message +
                            "</div>");
                        $("#alertdata").attr('hidden', false);
                        $('#file').val(null);
                    } else {
                        console.log(result);
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

    <script>
        $(document).ready(function() {
            var developers = @json($developers);
            var locations = @json($locations);
            $("#developer").autocomplete({
                source: developers
            });
            $("#community_location").autocomplete({
                source: locations
            });
        });
    </script>

@endpush
