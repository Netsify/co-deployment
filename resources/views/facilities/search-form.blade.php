@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('facilities.search') }}">
            <div class="mb-3">
                <label for="name_or_id" class="form-label">{{ __('facility.facility_name_or_id') }}</label>
                <input type="text" class="form-control" id="name_or_id" name="name_or_id">
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">{{ __('facility.type') }}</label>
                <select class="form-select" id="type" name="type">
                    <option value="" selected>{{ __('facility.select_type')  }}</option>
                    @foreach($types as $type)
                        <option value="{{ $type->slug }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="owner" class="form-label">{{ __('facility.owner') }}</label>
                <input type="text" class="form-control" id="owner" name="owner">
            </div>
            <div class="mb-3">
                <label for="facility" class="form-label">{{ __('facility.my_facilities') }}</label>
                <select class="form-select" id="facility" name="facility">
                    <option value="0" selected>{{ __('facility.select_facility') }}</option>
                @foreach($facilities as $facility)
                        <option value="{{ $facility->identificator }}">{{ $facility->title }} ({{ $facility->type->name }})</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('facility.find') }}</button>
        </form>
    </div>
@endsection