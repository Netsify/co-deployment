@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>{{ $facility->title }}</b> ID: {{ $facility->identificator }}
                    </div>
                    <div class="card-body">
                        <p class="card-text text-justify">{{ $facility->description }}</p>
                        <div class="row">
                            <div class="col col-sm-4 text-center">
                                <p><b>{{ __('facility.type') }}: </b>{{ $facility->type->name }}</p>
                            </div>
                            <div class="col col-sm-4 text-center">
                                <p><b>{{ __('facility.location') }}: </b>{{ $facility->location }}</p>
                            </div>
                            <div class="col col-sm-4 text-center">
                                <p><b>{{ __('facility.owner') }}: </b>{{ $facility->user->full_name }}</p>
                            </div>
                        </div>
                        <hr>
                        <h5 class="card-text">{{ __('facility.attachments') }}</h5>
                        @forelse($facility->files as $file)
                            <p>
                                <a href="{{ $file->link }}" target="_blank"
                                   class="btn btn-sm btn-link">{{ $file->name }}</a>
                            </p>
                        @empty
                            <p>{{ __('facility.no_loaded_files') }}</p>
                        @endforelse

                        @can('use-advanced-search')
                            @if ($facility->compatibility_level)
                                <hr>
                                <div class="row">
                                    <p class="card-text text-justify">
                                        <b>{{ __('facility.c_level') }}: </b>{{ $facility->compatibility_level }}
                                    </p>
                                </div>
                                <div class="row">
                                    @if($proposal_is_not_exist)
                                    {{--Форма отправки предложения--}}
                                    <x-proposal-form :sender-facility="$my_facility" :receiver-facility="$facility"/>
                                    {{--Форма отправки предложения--}}
                                    @endif
                                </div>
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
        </div>
@endsection