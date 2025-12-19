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

    <div @class(['container'])>

        <div @class(['text-center', 'mt-3'])>
            <h2>World Countries</h2>
            <hr>
        </div>

        <div @class(['row']) style="margin-top: 45px">
            <div @class(['col-md-8'])>
                <div @class(['card', 'shadow', 'mb-3'])>
                    <div @class(['card-header'])>
                        <h5>World Countries</h5>
                    </div>
                    <div @class(['card-body'])>
                        <div @class(['table-responsive'])>
                            <table @class(['table', 'table-hover', 'table-condensed', 'table-sm']) id="countries">
                                <thead>
                                    <tr>
                                        <th>Country Name</th>
                                        <th>Capital City</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div @class(['col-md-4'])>
                <div @class(['card', 'shadow', 'mb-3'])>
                    <div @class(['card-header'])>
                        <h5 @class(['card-title'])>
                            Country Form
                        </h5>
                    </div>
                    <div @class(['card-body'])>
                        <form action="{{ route('country.store') }}" method="POST" id="store_country_form">
                            @csrf
                            <div @class(['mb-3'])>
                                <label for="country_name" @class(['form-label'])>Country Name</label>
                                <input type="text" name="country_name" id="country_name"
                                    @class(['form-control']) placeholder="Enter country name">
                                <span @class(['text-danger', 'error-text', 'country_name_error'])></span>
                            </div>
                            <div @class(['mb-3'])>
                                <label for="capital_city" @class(['form-label'])>Capital Name</label>
                                <input type="text" name="capital_city" id="capital_city"
                                    @class(['form-control']) placeholder="Enter capital city">
                                <span @class(['text-danger', 'error-text', 'capital_city_error'])></span>
                            </div>
                            <div @class(['form-group'])>
                                <button type="submit" @class(['btn', 'btn-primary'])>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modal-form')

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
                        toastr.success(data.message);
                        $(form).find('button').text('Submit');
                        $(form).trigger('reset');
                        table.ajax.reload(null, false);
                    }
                },
                error: function(data) {
                    $(form).find('button').text('Submit');

                    $.each(data.responseJSON.errors, function(prefix, value) {
                        $(form).find('span.' + prefix + '_error').text(value[0]);
                    });

                    toastr.error(data.message);
                },
                error: function(xhr) {
                    $(form).find('button').text('Submit');

                    if (xhr.status === 422) {
                        // Validation errors
                        $.each(xhr.responseJSON.errors, function(prefix, value) {
                            $(form).find('span.' + prefix + '_error').text(value[0]);
                        });
                    } else {
                        // Any other error
                        toastr.error(xhr.responseJSON.message ?? 'Something went wrong');
                    }
                }
            })
        })

        // Display Saved Country
        let table = $('#countries').DataTable({
            processing: true,
            info: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            pageLength: 5,
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],
            ajax: {
                url: "{{ route('country.getCountries') }}",
                type: 'GET',
            },
            columns: [{
                    data: 'country_name',
                    name: 'country_name'
                },
                {
                    data: 'capital_city',
                    name: 'capital_city'
                },
                {
                    data: 'actions',
                    name: 'actions'
                },
            ],
        });

        // Edit Selected Country (Using Event Delegation and [on vs click func]) this is better with button will load in the future
        $(document).on('click', '.edit-country-btn', function() {
            let id = $(this).data('id');
            let modal = $('#modal-form');

            $.get("{{ route('country.getCountry') }}", {
                id: id
            }, function(res) {
                modal.find('input[name="country_id"]').val(res.data.id);
                modal.find('#country_name').val(res.data.country_name);
                modal.find('#capital_city').val(res.data.capital_city);
                modal.modal('show'); // 👈 هنا بقى هيظهر
            });
        });


        // Update Selected Country
        $('#update_country_form').on('submit', function(e) {
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);

            $.ajax({
                url: $(form).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status) {
                        toastr.success(data.message);
                        $('#modal-form').modal('hide');
                        table.ajax.reload(null, false);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function(prefix, value) {
                            $(form).find('span.' + prefix + '_error').text(value[0]);
                        });
                    } else {
                        toastr.error(xhr.responseJSON.message ?? 'Something went wrong');
                    }
                }
            });
        });
    </script>
</body>

</html>
