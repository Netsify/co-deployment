@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-12">
                <h4>{{ __('facility.result_search') }}</h4>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @forelse($facilities as $facility)
                        <div class="col">
                            {{-- Отображаем превью объекта из компонента --}}
                            <x-facility-preview :facility="$facility" show-compatibility-level="true">
                                <div class="d-grid gap-2">
                                    <a href="{{ $facility->link ?? route('facilities.show', $facility->id) }}"
                                       class="btn btn-sm btn-info">{{ __('facility.open') }}</a>
                                </div>
                            </x-facility-preview>
                            {{-- Отображаем превью объекта из компонента --}}
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