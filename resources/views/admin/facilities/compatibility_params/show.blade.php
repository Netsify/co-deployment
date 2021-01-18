@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-sm-2">
                @include('admin.sidebar')
            </div>
            <div class="col col-sm-10">
                <div class="card">
                    <div class="card-header">
                        {{ __('compatibility_param.param_view') }}
                    </div>
                    <div class="card-body">
                        <p>
                            <b>{{ __('compatibility_param.param_name') }}: </b>
                            {{ $compatibilityParam->translate('ru')->name }}
                            ({{ __('compatibility_param.en') }}) {{ $compatibilityParam->translate('en')->name }}
                        </p>
                        <p>
                            <b>{{ __('compatibility_param.group') }}: </b>
                            {{ $compatibilityParam->group->name }}
                        </p>
                        <p>
                            <b>{{ __('compatibility_param.min_val') }}: </b>
                            {{ $compatibilityParam->min_val}}
                        </p>
                        <p>
                            <b>{{ __('compatibility_param.max_val') }}: </b>
                            {{ $compatibilityParam->max_val}}
                        </p>
                        <p>
                            <b>{{ __('compatibility_param.default_val') }}: </b>
                            {{ $compatibilityParam->default_val}}
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection