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
                        <div class="btn-toolbar" style="float: right">
                            <form action="{{ route('admin.facilities.compatibility_params.destroy', $compatibilityParam) }}" method="post">
                                <a href="{{ route('admin.facilities.compatibility_params.edit', $compatibilityParam) }}"
                                   class="btn btn-sm btn-success">{{ __('compatibility_param.edit') }}</a>

                                @method('DELETE')
                                @csrf
                                <button class="btn btn-sm btn-danger">{{ __('compatibility_param.delete') }}</button>
                            </form>
                        </div>
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
                        <table class="table table-sm table-bordered">
                            <thead>
                            <tr>
                                @foreach(['road', 'railway', 'energy', 'ict', 'other'] as $header)
                                <th scope="col">{{ __("compatibility_param.{$header}_description") }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(config('app.locales') as $locale)
                            <tr>
                                @foreach(['road', 'railway', 'energy', 'ict', 'other'] as $header)
                                <td>{{ $compatibilityParam->translate($locale)->{"description_{$header}"} }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection