@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-sm-3">
                @include('knowledgebase.categories.sidebar')
            </div>
            <div class="col col-sm-9">
                <h3>{{ $title }}</h3>
                @if(session()->has('success'))
                    <x-alert class="success" message="{{ session()->get('success') }}"/>
                @endif

                @forelse($articles as $article)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $article->title }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted float-right">{{ $article->user->full_name }}<x-icon-verified
                                    :user="$article->user"></x-icon-verified></p>
                            <p>{{ $article->preview }}</p>

                            <a href="{{ route('articles.show', $article) }}" class="card-link">{{ __('knowledgebase.view') }}</a>
                        </div>
                        <div class="card-footer text-muted">
                            {{ $article->created_at }}
                        </div>
                    </div>
                    <hr>
                @empty
                    <h4>{{ __('knowledgebase.articles_not_found') }}</h4>
                @endforelse
            </div>
        </div>
    </div>
@endsection
