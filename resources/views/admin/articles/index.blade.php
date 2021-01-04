@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>{{ $title }}</h4>
        @if(session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif
        @forelse($articles as $article)
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-sm-6">
                            <h5 class="card-title">{{ $article->title }}</h5>
                        </div>
                        <div class="col col-sm-6">
                            <div class="btn-toolbar" style="float: right" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group me-2" role="group" aria-label="First group">
                                    <form action="{{ route('admin.articles.publicate', $article) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success">{{ __('knowledgebase.publicate') }}</button>
                                    </form>
                                </div>
                                <div class="btn-group me-2" role="group" aria-label="Second group">
                                    @csrf
                                    @method('PUT')
                                    <form action="{{ route('admin.articles.reject', $article) }}" method="post">
                                        <button type="submit" class="btn btn-warning">{{ __('knowledgebase.reject') }}</button>
                                    </form>
                                </div>
                           </div>
                        </div>
                    </div>
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
            <h5>{{ __('knowledgebase.articles_not_found') }}</h5>
        @endforelse
    </div>
@endsection