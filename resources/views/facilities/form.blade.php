@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">
                    {{ __('facility.new_facility') }}
                </div>
                <div class="card-body">
                    @if(session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <form action="{{ route('facilities.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="title" class="col-sm-2 col-form-label">{{ __('facility.title') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                                @error('title')
                                    <x-invalid-feedback :message="$message"/>
                                @enderror
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
                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}">
                                @error('location')
                                    <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="description" class="col-sm-2 col-form-label">{{ __('facility.description') }}</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="description" name="description">
                                    {{ old('description') }}
                                </textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="attachments" class="col-sm-2 col-form-label">{{ __('facility.attachments') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="file" id="attachments" name="attachments[]" multiple>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
