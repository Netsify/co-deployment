@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
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

                        <form action="{{ route('profile.update', $user) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="photo" class="col-form-label">{{ __('dictionary.Photo') }}</label>

                                <div class="mb-3">
                                    <img src="{{ $user->photo }}" height="300">
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
                                <label for="role" class="col-form-label">{{ __('dictionary.Role') }}</label>
                                <select name="role" class="form-control @error('role') is-invalid @enderror">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ (old('role') ?? $user->role->id) === $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="col-form-label">{{ __('dictionary.Phone') }}</label>
                                <input type="tel" name="phone"
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

                            <button type="submit" class="btn btn-success">{{ __('dictionary.Save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
