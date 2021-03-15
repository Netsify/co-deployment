@extends('layouts.app')

@section('content')
    <div class="container" id="verified">
        <div class="card mb-3">
            <div class="card-header">
                {{ __('admin.users') }}
            </div>

            <div class="card-body">
                <form method="POST">
                    @method('PUT')
                    @csrf
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
                                    <div id="icon" :verified="{{ $user->verified }}">
                                        {{ $user->full_name }}
                                        {{--                                        <span v-if="user.verified || (user && user.id === {{ $user->id }} && user.verified)">--}}
                                        {{--                                            <icon-verified :primary="{{ $user }}" :url="'{{ $user->verified_url }}'"--}}
                                        {{--                                                           :title="'{{ $user->verified_title }}'" :user="user"></icon-verified>--}}
                                        {{--                                        </span>--}}
                                    </div>
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    {{ $user->role->name }}
                                </td>
                                <td>
                                    <input type="checkbox" name="verified" @change="setVerified"
                                           class="form-check-input" route="{{ route('admin.users.verify', $user) }}"
                                        {{ $user->verified ? 'checked' : '' }}>

                                    <div style="color: red" v-if="user">
                                        <span v-if="user.id === {{ $user->id }}">
                                            @{{ message }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
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
