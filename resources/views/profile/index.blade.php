@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header">
                        {{ __('dictionary.PersonalData') }}
                        <div class="btn-toolbar" role="toolbar" style="float: right">
                            <div class="btn-group me-2" role="group">
                                <a href="{{ route('profile.edit', $user) }}"
                                   class="btn btn-sm btn-success"
                                   style="float: right">{{ __('dictionary.EditProfile') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-6" style="margin-left: 30px; margin-right: -30px">
                                <label for="photo" class="col-sm-3">{{ __('dictionary.Photo') }}</label>
                            </div>

                            <div class="col-sm-5">
                                <img alt="user_photo" src="{{ $user->photo }}" height="200">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <img alt="user_icon" src="{{ $user->user_icon }}" height="30"><label
                                    for="first_name" class="col-sm-4">{{ __('dictionary.FirstName') }}</label>
                            </div>

                            <div class="col-sm-5">
                                {{ $user->first_name }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <img alt="user_icon" src="{{ $user->user_icon }}" height="30"><label
                                    for="last_name" class="col-sm-4">{{ __('dictionary.LastName') }}</label>
                            </div>

                            <div class="col-sm-6">
                                {{ $user->last_name }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <img alt="user_icon" src="{{ $user->user_icon }}" height="30"><label
                                    for="role" class="col-sm-4">{{ __('dictionary.Role') }}</label>
                            </div>

                            <div class="col-sm-6">
                                {{ $user->role->name }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <img alt="user_icon" src="{{ $user->phone_icon }}" height="30"><label
                                    for="phone" class="col-sm-4">{{ __('dictionary.Phone') }}</label>
                            </div>

                            <div class="col-sm-6">
                                {{ $user->phone }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <img alt="user_icon" src="{{ $user->mail_icon }}" height="30"><label
                                    for="email" class="col-sm-4">{{ __('dictionary.Email') }}</label>
                            </div>

                            <div class="col-sm-6">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <img alt="user_icon" src="{{ $user->address_icon }}" height="30"><label
                                    for="organization" class="col-sm-4">{{ __('dictionary.Organization') }}</label>
                            </div>

                            <div class="col-sm-6">
                                {{ $user->organization }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <img alt="user_icon" src="{{ $user->address_icon }}" height="30"><label
                                    for="summary" class="col-sm-6">{{ __('dictionary.Summary') }}</label>
                            </div>

                            <div class="col-sm-6">
                                {{ $user->summary }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
