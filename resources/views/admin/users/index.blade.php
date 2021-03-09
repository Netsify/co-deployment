@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('admin.users') }}
            </div>

            <div class="card-body">
                <form method="POST">
                    @method('DELETE')
                    @csrf
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('dictionary.FullName') }}</th>
                                <th scope="col">{{ __('dictionary.Email') }}</th>
                                <th scope="col">{{ __('dictionary.Role') }}</th>
                                <th scope="col">{{ __('dictionary.Verified') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $user->full_name }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    {{ $user->role->name }}
                                </td>
                                <td>
                                    {{ $user->verified }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection
