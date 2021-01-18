@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-sm-3">
                @include('admin.facilities.sidebar')
            </div>
            <div class="col col-sm-9">
                <h4>{{ __('facility.facilities') }}</h4>
            </div>
        </div>
    </div>
@endsection