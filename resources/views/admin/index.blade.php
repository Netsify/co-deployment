@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-sm-3">
                @include('admin.sidebar')
            </div>
            <div class="col col-sm-9">
                <h4>{{ __('admin.welcome_to_admin_panel') }}</h4>
            </div>
        </div>
    </div>
@endsection