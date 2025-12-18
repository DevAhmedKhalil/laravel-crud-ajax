<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>World Countries</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
    <style>
        table tbody td:last-child {
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="text-center mt-3">
            <h2>World Countries</h2>
            <hr>
        </div>

        <div class="row" style="margin-top: 45px">
            <div class="col-md-8">
                <div class="card shadow mb-3">
                    <div class="card-header">
                        <h5>World Countries</h5>
                    </div>
                    <div class="card-body">
                        ...
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow mb-3">
                    <div class="card-header">
                        <h5 class="card-title">
                            Country Form
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('country.store') }}" method="POST" id="store_country_form">
                            @csrf
                            <div class="mb-3">
                                <label for="country_name" class="form-label">Country Name</label>
                                <input type="text" name="country_name" id="country_name" class="form-control"
                                    placeholder="Enter country name">
                                <span class="text-danger error-text country_name_error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="capital_city" class="form-label">Capital Name</label>
                                <input type="text" name="capital_city" id="capital_city" class="form-control"
                                    placeholder="Enter capital city">
                                <span class="text-danger error-text capital_city_error"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>
    <script>
        toastr.options.preventDuplicates = true;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Store new Country name & Capital city form
        $('form#store_country_form').on('submit', function(e) {
            e.preventDefault();
            let form = this;
            let formdata = new FormData(form);

            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: formdata,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                    $(form).find('button').text('Sending..');
                },
                success: function(data) {
                    if (data.status == 1) {
                        $(form).find('button').text('Submit');
                        $(form).trigger('reset');
                        toastr.success(data.message);
                    }
                },
                error: function(data) {
                    $(form).find('button').text('Submit');

                    $.each(data.responseJSON.errors, function(prefix, value) {
                        $(form).find('span.' + prefix + '_error').text(value[0]);
                    });

                    toastr.error(data.message);
                }

            })
        })
    </script>
</body>

</html>
