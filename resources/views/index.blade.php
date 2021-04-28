@extends('layouts.app')

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

        <div class="row">
            <div class="col col-sm-6">
                <div class="card bg-dark text-white">
                    <img src="{{ $road_image }}" class="card-img" alt="..." style="opacity: 0.67; height: 390px;">
                    <div class="card-img-overlay">
                        <br><br><br><br><br><br><br>
                        <a  class="btn btn-outline-light" href="{{ route('login') }}">
                            <h3 class="card-title text-center">{{ __('dictionary.infrastructure_owners') }}</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col col-sm-6">
                <div class="card bg-dark text-white">
                    <img src="{{ $ict_image }}" class="card-img" alt="..." style="opacity: 0.67; height: 390px;">
                    <div class="card-img-overlay">
                        <br><br><br><br><br><br><br>
                        <a  class="btn btn-outline-light" href="{{ route('login') }}">
                            <h3 class="card-title text-center">{{ __('dictionary.ict_operators') }}</h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection