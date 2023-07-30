<div class="box-body">
    <h2>Mesas</h2>
    <div class="form-check">
        <br>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
            @foreach ($restaurantTables as $restaurantTable)
                <div class="col-lg-4 col-md-6 col-sm-4 col-xs-12 radio">
                <input class="form-check-input" type="radio" value="{{ $restaurantTable->id }}" name="restaurant_table_id" id="{{ $restaurantTable->id }}">

                <label class="form-check-label" for="{{ $restaurantTable->id }}">{{ $restaurantTable->name }}</label>
                </div>
            @endforeach
        </div>
    </div>
</div>
