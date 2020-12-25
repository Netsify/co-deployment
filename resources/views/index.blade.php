@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>{{ __('knowledgebase.last_added_articles') }}</h4>
        @forelse($articles as $article)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $article->title }}
                        <span style="float: right" class="card-subtitle mb-2 text-muted">{{ $article->user->full_name }}</span>
                    </h5>
                    <p class="card-text">{{ $article->preview }}...</p>
                    <a href="{{ route('articles.show', $article) }}" class="card-link">{{ __('knowledgebase.view') }}</a>
                    <small style="float: right">{{ $article->created_at }}</small>
                </div>
            </div>
            <br>
        @empty
            <p>{{ __('knowledgebase.articles_not_found') }}</p>
        @endforelse
    </div>
@endsection