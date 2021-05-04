@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <h2 class="text-center">{{ __('dictionary.inform_portal') }}</h2>
                <br>
                <h5 class="text-center">{{ __('dictionary.motto1') }}</h5>
                <h5 class="text-center">{{ __('dictionary.motto2') }}</h5>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col col-sm-6">
                <div class="card bg-dark text-white">
                    <img id="card-img" src="{{ $road_image }}" class="card-img" alt="road_image">
                    <div class="card-img-overlay text-center d-flex align-items-center justify-content-center">
                        <a id="a-title" class="btn btn-outline-light" href="{{ route('login') }}">
                            <h1 class="card-title">{{ __('dictionary.infrastructure_owners') }}</h1>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col col-sm-6">
                <div class="card bg-dark text-white">
                    <img id="card-img" src="{{ $ict_image }}" class="card-img" alt="ict_image">
                    <div class="card-img-overlay text-center d-flex align-items-center justify-content-center">
                        <a id="a-title" class="btn btn-outline-light" href="{{ route('login') }}">
                            <h1 class="card-title">{{ __('dictionary.ict_operators') }}</h1>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <em>
            <p style="text-indent: 2em;">{{ __('dictionary.main') }}</p>
        </em>

    </div>
@endsection
