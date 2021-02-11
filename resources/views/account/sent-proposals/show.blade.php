@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('proposal.incoming_proposal') }}
                <div class="btn-group" style="float: right">
                    <form action="" method="post">
                        @csrf
                        <div class="btn-group me-2" role="group" aria-label="First group">
                            <button type="submit" name="publicate" class="btn btn-success btn-sm">{{ __('proposal.accept') }}</button>
                        </div>
                    </form>

                    <form action="" method="post">
                        @csrf
                        <div class="btn-group me-2" role="group" aria-label="First group">
                            <button type="submit" name="publicate" class="btn btn-danger btn-sm">{{ __('proposal.decline') }}</button>
                        </div>
                    </form>
                </div>
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
                <p class="card-text"><b>{{ __('facility.facilities') }}: </b> ({{ __('facility.c_level') }}
                    = {{ $c_level }})</p>
                <div class="row">
                    @foreach($facilities as $facility)
                        <div class="col">
                            {{-- Отображаем превью объекта из компонента --}}
                            <x-facility-preview :facility="$facility">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('facilities.show', $facility->id) }}"
                                       class="btn btn-sm btn-info">{{ __('facility.open') }}</a>
                                </div>
                            </x-facility-preview>
                            {{-- Отображаем превью объекта из компонента --}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection