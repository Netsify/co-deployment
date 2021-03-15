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

                        <t-body :users="{{ $users }}" :route="{{ route('admin.users.verify', $user) }}"></t-body>
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
