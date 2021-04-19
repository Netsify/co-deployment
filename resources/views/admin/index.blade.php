@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-sm-2">
                @include('admin.sidebar')
            </div>
            <div class="col col-sm-10">
                <h4 style="text-align: center">{{ __('admin.welcome_to_admin_panel') }}</h4>
            </div>
        </div>
    </div>
@endsection
