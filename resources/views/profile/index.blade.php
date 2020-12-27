@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('dictionary.PersonalData') }}
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="photo">{{ __('dictionary.Photo') }}</label>
                        </div>

                        <div class="mb-3">
                            <label for="first_name">{{ __('dictionary.FirstName') }}</label>
                            {{ $user->first_name }}
                        </div>

                        <div class="mb-3">
                            <label for="last_name">{{ __('dictionary.LastName') }}</label>
                            {{ $user->last_name }}
                        </div>

                        <div class="mb-3">
                            <label for="role">{{ __('dictionary.Role') }}</label>
                            {{ $user->role->name }}
                        </div>

                        <div class="mb-3">
                            <label for="phone">{{ __('dictionary.Phone') }}</label>
                            {{ $user->phone }}
                        </div>

                        <div class="mb-3">
                            <label for="email">{{ __('dictionary.Email') }}</label>
                            {{ $user->email }}
                        </div>

                        <div class="mb-3">
                            <label for="password">{{ __('dictionary.Password') }}</label>
                        </div>

                        <div class="mb-3">
                            <label for="organization">{{ __('dictionary.Organization') }}</label>
                            {{ $user->organization }}
                        </div>

                        <div class="mb-3">
                            <label for="summary">{{ __('dictionary.Summary') }}</label>
                            {{ $user->summary }}
                        </div>

                        <a class="btn btn-success" href="{{ route('profile.edit', $user) }}">
                            {{ __('dictionary.EditProfile') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
