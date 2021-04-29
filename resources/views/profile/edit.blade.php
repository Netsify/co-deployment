@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/label.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('dictionary.EditProfile') }}
                    </div>

                    <div class="card-body">

                        @if (session()->has('message'))
                            <div class="alert alert-info d-flex align-items-center justify-content-center mb-2">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form action="{{ route('profile.delete_photo', $user) }}" method="POST" id="photo">
                            @method('DELETE')
                            @csrf
                        </form>

                        <form action="{{ route('profile.update', $user) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="photo" class="col-form-label">{{ __('dictionary.Photo') }}</label>

                                <div class="mb-3">
                                    <img src="{{ $user->photo }}" height="200" alt="photo">
                                </div>

                                <div class="mb-3">
                                    @if ($user->photo_path)
                                        <button type="submit" class="btn btn-danger btn-sm" form="photo">
                                            {{ __('knowledgebase.delete') }}
                                        </button>
                                    @endif
                                </div>

                                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">

                                @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="first_name" class="col-form-label">{{ __('dictionary.FirstName') }}</label>
                                <input type="text" name="first_name"
                                       class="form-control @error('first_name') is-invalid @enderror"
                                       value="{{ old('first_name') ?? $user->first_name }}">

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="col-form-label">{{ __('dictionary.LastName') }}</label>
                                <input type="text" name="last_name"
                                       class="form-control @error('last_name') is-invalid @enderror"
                                       value="{{ old('last_name') ?? $user->last_name }}">

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="role_id" class="col-form-label">{{ __('dictionary.Role') }}</label>
                                <select name="role_id" class="form-control @error('role_id') is-invalid @enderror">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ (old('role_id') ?? $user->role->id) === $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('role_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="col-form-label">{{ __('dictionary.phone_format', ['format' => "+XX(XXX)XXX-XX-XX"]) }}</label>
                                <input type="tel" name="phone"
                                       pattern="\+[\d]{1,3}\([\d]{3}\)[\d]{3}-[\d]{2}-[\d]{2}"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') ?? $user->phone }}">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="col-form-label">{{ __('dictionary.Email') }}</label>
                                <input type="text" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') ?? $user->email }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="col-form-label">{{ __('dictionary.Password') }}</label>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password" autocomplete="new-password"
                                       placeholder="{{ __('dictionary.UpdatePassword') }}">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password-confirm" class="col-form-label">{{ __('dictionary.ConfirmPassword') }}</label>

                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" autocomplete="new-password"
                                       placeholder="{{ __('dictionary.UpdatePassword') }}">
                            </div>

                            <div class="mb-3">
                                <label for="organization" class="col-form-label">{{ __('dictionary.Organization') }}</label>
                                <input type="text" name="organization"
                                       class="form-control @error('organization') is-invalid @enderror"
                                       value="{{ old('organization') ?? $user->organization }}">

                                @error('organization')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="summary" class="col-form-label">{{ __('dictionary.Summary') }}</label>
                                <input type="text" name="summary"
                                       class="form-control @error('summary') is-invalid @enderror"
                                       value="{{ old('summary') ?? $user->summary }}">

                                @error('summary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('dictionary.Save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
