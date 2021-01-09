@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">
                    {{ __('facility.new_facility') }}
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3 row">
                            <label for="title" class="col-sm-2 col-form-label">{{ __('facility.title') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="facility_id" class="col-sm-2 col-form-label">{{ __('facility.facility_id') }}</label>
                            <div class="col-sm-10">
                                <div class="form-text">{{ __('facility.facility_id_description') }}</div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="visibility" class="col-sm-2 col-form-label">{{ __('facility.visibility') }}</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="visibility" name="visibility">
                                    <option disabled>{{ __('facility.select_visibility') }}</option>
                                    @foreach($visibilities as $visibility)
                                        <option value="{{ $visibility->id }}">{{ $visibility->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="type" class="col-sm-2 col-form-label">{{ __('facility.type') }}</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="type" name="type">
                                    <option disabled>{{ __('facility.select_type') }}</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="location" class="col-sm-2 col-form-label">{{ __('facility.location') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
