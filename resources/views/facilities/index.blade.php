@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <h4>{{ __('facility.facilities') }}</h4>
                @forelse($facilities as $facility)
                <div class="card">
                    <div class="card-header">
                        {{ $facility->title }}
                    </div>
                    <div class="card-body">

                    </div>
                </div>
                @empty
                    <h4>{{ __('facility.facilities_not_found') }}</h4>
                @endforelse
            </div>
        </div>
    </div>
@endsection
