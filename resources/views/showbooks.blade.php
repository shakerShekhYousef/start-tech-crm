@extends('layouts.app')

@push('head')
    <title>Leads pool</title>

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
                            Leads Pool
                        </h3>

                    </div>

                    <div class="card-bod" style="overflow:scroll; width: 96%; margin-left: 2%">
                        <div class="alert alert-error pb-3 mt-3" role="alert" id="alertdiv" hidden></div>

                        <div class="row mt-4 mb-5">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <h4>Customer status</h4>
                                </div>
                                <select id="userstatus" class="form-control mt-2">
                                    <option value="">All</option>
                                    @foreach ($userstatus as $item)
                                        <option value="{{ $item }}">{{ ucfirst($item) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <h4>Campaign source</h4>
                                </div>
                                <select id="campaignsource" class="form-control mt-2">
                                    <option value="">All</option>
                                    @foreach ($campaignsources as $campaignsource)
                                        <option value="{{ $campaignsource }}">{{ ucfirst($campaignsource) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <span id="alertdata"></span>
                        <div class="table-responsiv">
                            <table class="table table-bordere" style="overflow:scroll" id="bookslist" width="300%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Utm source</th>
                                        <th>Utm medium</th>
                                        <th>Utm campaign</th>
                                        <th>Campaign source</th>
                                        <th>Bedroom</th>
                                        <th>Project</th>
                                        <th>Created date</th>
                                        <th>Customer status</th>
                                        <th>Comment</th>
                                        <th></th>
                                        <th>Comments</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>
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

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
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
                    "url": "{{ route('showbooks') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        return $.extend({}, d, {
                            _token: "{{ csrf_token() }}",
                            "userstatus": $('#userstatus').val(),
                            "campaignsource": $('#campaignsource').val(),
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
                        width: 70
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
                        data: 'utm_source',
                        name: 'utm_source',
                        width: 250
                    },
                    {
                        data: 'utm_medium',
                        name: 'utm_medium',
                        width: 250
                    },
                    {
                        data: 'utm_campaign',
                        name: 'utm_campaign',
                        width: 250
                    },
                    {
                        data: 'campaign_name',
                        name: 'campaign_name',
                        width: 250
                    },
                    {
                        data: 'number_of_beds',
                        name: 'number_of_beds',
                        width: 200
                    },
                    {
                        data: 'project',
                        name: 'project',
                        width: 200
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        width: 250
                    },
                    {
                        data: "customerstatus",
                        width: 700
                    },
                    {
                        data: "comment",
                        width: 400
                    },
                    {
                        data: "addcomment",
                        width: 200
                    },
                    {
                        data: "comments",
                        width: 1000
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width: 350
                    },
                ],
                "drawCallback": function(settings) {
                    $('#bookslist tbody').on('click', '.addcomment', function() {
                        $("#alertdata").empty();
                        var row = table.row($(this).parents('tr')).nodes().to$();
                        currentInputValue = row.find('td:eq(12) input').val();
                        currentcustomerstatuindex = row.find('td:eq(11)').find(":selected").index();
                        currentcustomerstatus = row.find('td:eq(11)').find(":selected").text();
                        bookid = row.find('td:eq(13) input').attr('id').slice(10);
                        if (currentcustomerstatuindex == 0) {
                            $("#alertdata").empty();
                            $("#alertdata").append(
                                "<div class= 'alert alert-danger'> You should select user status </div>"
                            );
                            $("#alertdata").attr('hidden', false);
                        } else if (currentInputValue == '') {
                            $("#alertdata").empty();
                            $("#alertdata").append(
                                "<div class= 'alert alert-danger'> You should enter comment </div>"
                            );
                            $("#alertdata").attr('hidden', false);
                        } else {
                            $.ajax({
                                url: "{{ route('add_lead_comment') }}",
                                dataType: "json",
                                type: "post",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    'book_id': bookid,
                                    'comment': currentInputValue,
                                    'customerstate': currentcustomerstatus,
                                },
                                success: function(result) {
                                    if (result.success) {
                                        $("#alertdata").empty();
                                        $("#alertdata").append(
                                            "<div class= 'alert alert-success'>" +
                                            result.message +
                                            "</div>");
                                        $("#alertdata").attr('hidden', false);
                                        $('#bookslist').DataTable().draw();
                                    } else {
                                        $("#alertdata").empty();
                                        $("#alertdata").append(
                                            "<div class= 'alert alert-danger'>" +
                                            result.message +
                                            "</div>");
                                        $("#alertdata").attr('hidden', false);
                                    }
                                },
                                error: function(error) {
                                    $("#alertdata").empty();
                                    $.each(error.responseJSON.errors, function(
                                        index,
                                        value) {
                                        $("#alertdata").append(
                                            "<div class= 'alert alert-danger'>" +
                                            index +
                                            "   " + value + "</div>");
                                    });
                                    $("#alertdata").attr('hidden', false);
                                }
                            });
                        }
                    })
                }
            });

            $('#userstatus').change(function() {
                $("#alertdata").empty();
                $('#bookslist').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "userstatus": $('#userstatus').val(),
                    "campaignsource": $('#campaignsource').val(),
                }, );
                $('#bookslist').DataTable().draw();
            });
            
            $('#campaignsource').change(function() {
                $("#alertdata").empty();
                $('#bookslist').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "userstatus": $('#userstatus').val(),
                    "campaignsource": $('#campaignsource').val(),
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
