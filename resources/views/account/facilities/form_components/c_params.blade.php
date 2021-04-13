@foreach($compatibility_params as $group)
    <h5 class="text-center">{{ $group->name }}</h5>
    @foreach($group->params as $param)
        <div class="row">
            <div class="col-sm-4">
                <label for="c_param[{{ $param->id }}]" class="form-label">{{ $param->name }}</label>
            </div>
            <div class="col-sm-4">
                <c-param-slider name="c_param[{{ $param->id }}]" min="{{ $param->min_val }}" max="{{ $param->max_val }}"
                                selected-value="{{ optional($facility->compatibilityParam($param->id))->value ?? $param->default_val }}"
                                id="c_param[{{ $param->id }}]"
                ></c-param-slider>
                {{--<input type="range" id="c_param[{{ $param->id }}]" name="c_param[{{ $param->id }}]" class="form-range"
                       min="{{ $param->min_val }}" max="{{ $param->max_val }}"
                       value="{{ optional($facility->compatibilityParam($param->id))->value ?? $param->default_val }}" id="customRange2">--}}
            </div>
            <c-param-description :descriptions="descriptions" type-id="{{ $param->id }}"></c-param-description>
        </div>
    @endforeach
    <hr>
@endforeach