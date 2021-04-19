@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-sm-3">
                @include('knowledgebase.categories.sidebar')
            </div>
            <div class="col col-sm-9">
                <p class="h3 mb-4" style="text-align: center">{{ __('knowledgebase.KB') }}</p>

                <p>{{ __('knowledgebase_main.first_p') }}</p>

                <p>{{ __('knowledgebase_main.second_p') }}</p>
            </div>
        </div>
    </div>
@endsection
