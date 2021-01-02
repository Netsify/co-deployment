@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        {{ __('dictionary.PersonalData') }}
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="photo" class="col-sm-3">{{ __('dictionary.Photo') }}</label>

                            <div class="col-sm-9">
                                <img src="{{ $user->photo }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="first_name" class="col-sm-3">{{ __('dictionary.FirstName') }}</label>

                            <div class="col-sm-9">{{ $user->first_name }}</div>
                        </div>

                        <div class="row mb-3">
                            <label for="last_name" class="col-sm-3">{{ __('dictionary.LastName') }}</label>

                            <div class="col-sm-9">{{ $user->last_name }}</div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-sm-3">{{ __('dictionary.Role') }}</label>

                            <div class="col-sm-9">{{ $user->role->name }}</div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-sm-3">{{ __('dictionary.Phone') }}</label>

                            <div class="col-sm-9">{{ $user->phone }}</div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-sm-3">{{ __('dictionary.Email') }}</label>

                            <div class="col-sm-9">{{ $user->email }}</div>
                        </div>

                        <div class="row mb-3">
                            <label for="organization" class="col-sm-3">{{ __('dictionary.Organization') }}</label>

                            <div class="col-sm-9">{{ $user->organization }}</div>
                        </div>

                        <div class="row mb-3">
                            <label for="summary" class="col-sm-3">{{ __('dictionary.Summary') }}</label>

                            <div class="col-sm-9">{{ $user->summary }}</div>
                        </div>
                    </div>
                </div>
                <a class="btn btn-primary" href="{{ route('profile.edit', $user) }}">
                    {{ __('dictionary.EditProfile') }}
                </a>
            </div>
        </div>
    </div>
@endsection
