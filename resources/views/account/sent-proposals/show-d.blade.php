@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('proposal.incoming_proposal') }}
            </div>
            <div class="card-body">
                <h2 class="card-text">{{ __('proposal.if_facility_deleted') }}</h2>
            </div>
        </div>
    </div>
@endsection