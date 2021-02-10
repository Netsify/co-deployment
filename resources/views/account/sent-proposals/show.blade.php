@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('proposal.incoming_proposal') }}
            </div>
            <div class="card-body">
                <h5 class="card-title"><b>{{ __('account.sender') }}: </b>{{ $proposal->sender->full_name }}</h5>
                <p class="card-text"><b>{{ __('proposal.details') }}: </b>{{ $proposal->description }}</p>
                <p class="card-text">
                    <b>{{ __('proposal.attachments') }}:</b>
                    @forelse($proposal->files as $file)
                        <a href="{{ $file->getLink }}" class="btn btn-sm btn-link">{{ $file->name }}</a>
                        &nbsp;
                    @empty
                        {{ __('proposal.contains_no_attachments') }}
                    @endforelse
                </p>
                <p class="card-text"><b>{{ __('facility.facilities') }}: </b> ({{ __('facility.c_level') }} = {{ $c_level }})</p>
                    <div class="row">
                        @foreach($facilities as $facility)
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><b>{{ __('facility.facility') }}: </b>{{ $facility->title }}</h5>
                                        <p class="card-text"><b>{{ __('facility.type') }}: </b>{{ $facility->type->name }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
@endsection