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
                            {{ $article->preview  }}

                            <a href="#" class="card-link">{{ __('knowledgebase.View') }}</a>
                        </div>
                    </div>
                @empty
                    <h4>{{ __('knowledgebase.ArticlesNotFound') }}</h4>
                @endforelse
            </div>
        </div>
    </div>
@endsection