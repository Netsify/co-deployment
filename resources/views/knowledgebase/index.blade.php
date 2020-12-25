@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1>{{ __('knowledgebase.AllArticles') }}</h1>
                @forelse($articles as $article)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $article->title }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted float-right">{{ $article->user->full_name }}</p>
                            <p>{{ $article->preview  }}</p>

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