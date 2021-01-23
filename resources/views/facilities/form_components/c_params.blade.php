<compatibility-params></compatibility-params>

@foreach($compatibility_params as $group)
    <h5 class="text-center">{{ $group->name }}</h5>
    @foreach($group->params as $param)
        <div class="row">
            <div class="col-sm-4">
                <label for="customRange2" class="form-label">{{ $param->name }}</label>
            </div>
            <div class="col-sm-4">
                <input type="range" class="form-range" min="{{ $param->min_val }}" max="{{ $param->max_val }}"
                       value="{{ $param->default_val }}" id="customRange2">
            </div>
            <div class="col-sm-4">описание</div>
        </div>
        <hr>
    @endforeach
@endforeach