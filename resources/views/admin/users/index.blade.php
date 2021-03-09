@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
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
                                    <select class="form-select @error('verified') is-invalid @enderror"
                                            id="verified" name="verified">
                                        <option value="0" {{ (old('verified') ?? $user->verified) === 0 ? 'selected' : '' }}>Нет</option>
                                        <option value="1" {{ (old('verified') ?? $user->verified) === 1 ? 'selected' : '' }}>Да</option>
                                    </select>
                                    @error('verified')
                                        <x-invalid-feedback :message="$message"/>
                                    @enderror
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            formaction="{{ route('admin.users.destroy', $user) }}">
                                        {{ __('account.delete') }}
                                    </button>
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
