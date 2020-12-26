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
                            <strong>{{ Auth::user()->first_name }}</strong>
                        </div>

                        <div class="mb-3">
                            <label for="last_name">{{ __('dictionary.LastName') }}</label>
                            <strong>{{ Auth::user()->last_name }}</strong>
                        </div>

                        <div class="mb-3">
                            <label for="role">{{ __('dictionary.Role') }}</label>
                            <strong>{{ Auth::user()->role->name }}</strong>
                        </div>

                        <div class="mb-3">
                            <label for="phone">{{ __('dictionary.Phone') }}</label>
                            <strong>{{ Auth::user()->phone }}</strong>
                        </div>

                        <div class="mb-3">
                            <label for="email">{{ __('dictionary.Email') }}</label>
                            <strong>{{ Auth::user()->email }}</strong>
                        </div>

                        <div class="mb-3">
                            <label for="password">{{ __('dictionary.Password') }}</label>
                        </div>

                        <div class="mb-3">
                            <label for="organization">{{ __('dictionary.Organization') }}</label>
                            <strong>{{ Auth::user()->organization }}</strong>
                        </div>

                        <div class="mb-3">
                            <label for="summary">{{ __('dictionary.Summary') }}</label>
                            <strong>{{ Auth::user()->summary }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
