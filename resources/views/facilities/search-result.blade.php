@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-12">
                <h4>{{ __('facility.result_search') }}</h4>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @forelse($facilities as $facility)
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <b>{{ $facility->title }}</b>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-text">{{ $facility->preview }}</h6>
                                    <p><b>{{ __('facility.type') }}: </b> {{ $facility->type->name }}</p>
                                    <p><b>{{ __('facility.location') }}: </b> {{ $facility->location }}</p>
                                    <p><b>{{ __('facility.owner') }}: </b> {{ $facility->user->full_name }}</p>
                                    <hr>

                                    @can('use-advanced-search')
                                        <p><b>{{ __('facility.c_level') }}: </b> {{ $facility->compatibility_level }}</p>
                                    @endcan

                                    <div class="d-grid gap-2">
                                        <a href="{{ route('facilities.show', $facility->id) }}"
                                           class="btn btn-sm btn-info">{{ __('facility.open') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning" role="alert">
                            {{ __('facility.no_results_found') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
@endsection