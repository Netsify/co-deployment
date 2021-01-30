@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="">
            <div class="mb-3">
                <label for="name_or_id" class="form-label">{{ __('facility.facility_name_or_id') }}</label>
                <input type="text" class="form-control" id="name_or_id" name="name_or_id">
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">{{ __('facility.type') }}</label>
                <select class="form-select" id="type">
                    <option selected>{{ __('facility.select_type')  }}</option>
                    @foreach($facility_types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection