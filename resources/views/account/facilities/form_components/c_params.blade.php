@foreach($facility->compatibilityParams as $param)
    <h5 class="text-center">{{ $param->group->name }}</h5>

    <div class="row">
        <div class="col-sm-4">
            <label for="c_param[{{ $param->id }}]" class="form-label">{{ $param->name }}</label>
        </div>
        <div class="col-sm-4">
            <input type="range" id="c_param[{{ $param->id }}]" name="c_param[{{ $param->id }}]" class="form-range"
                   min="{{ $param->min_val }}" max="{{ $param->max_val }}"
                   value="{{ $param->pivot->value }}" id="customRange2">
        </div>
        <div class="col-sm-4">описание</div>
    </div>
    <hr>
@endforeach
