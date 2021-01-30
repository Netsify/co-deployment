@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('account.sent_proposals') }}
            </div>

            <div class="card-body">
                <table class="table mt-5">
                    <thead>
                    <tr>
                        <th scope="col">{{ __('knowledgebase.Title') }}</th>
                        <th scope="col">{{ __('knowledgebase.CategoryParent') }}</th>
                        <th scope="col">{{ __('knowledgebase.ArticlesCount') }}</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>

                    <tbody>
                    <form method="POST">
                        @method('DELETE')
                        @csrf
{{--                        @foreach($categories as $category)--}}
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            formaction="">
                                        {{ __('knowledgebase.delete') }}
                                    </button>
                                </td>
                            </tr>
{{--                        @endforeach--}}
                    </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
