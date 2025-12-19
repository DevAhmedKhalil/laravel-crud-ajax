<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('country.updateCountry') }}" id="update_country_form">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Country</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <input type="hidden" name="country_id">
                <div class="form-group">
                    <label for="country_name">Country Name</label>
                    <input type="text" class="form-control" id="country_name" name="country_name"
                        placeholder="Enter country name">
                    <span class="text-danger error-text country_name_error"></span>
                </div>
                <div class="form-group">
                    <label for="capital_city">Capital City</label>
                    <input type="text" class="form-control" id="capital_city" name="capital_city"
                        placeholder="Enter capital city">
                    <span class="text-danger error-text capital_city_error"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
