@extends('layouts.app')

@section('content')
    <div class="container" id="verified">
        <div class="card mb-3">
            <div class="card-header">
                {{ __('admin.users') }}
            </div>

            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('dictionary.FullName') }}</th>
                        <th scope="col">{{ __('dictionary.Email') }}</th>
                        <th scope="col">{{ __('dictionary.Role') }}</th>
                        <th scope="col">{{ __('dictionary.Verified') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $user->full_name }}<icon-verified :user="{{ $user }}"
                                                                     :url="'{{ $user->verified_url }}'"
                                                                     :title="'{{ $user->verified_title }}'"
                                                                     :userapi="userApi"></icon-verified>
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                {{ $user->role->name }}
                            </td>
                            <td>
                                <input type="checkbox" name="verified" @change="setVerified"
                                       :checked="{{ $user->verified }}" class="form-check-input"
                                       route="{{ route('admin.users.verify', $user) }}">

                                <div style="color: red">
                                    <span v-if="userApi.id === {{ $user->id }}">
                                        @{{ message }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/users.js') }}" defer></script>
@endsection
