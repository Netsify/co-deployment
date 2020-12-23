@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        {{ $article->title }}
                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-success" style="float: right">{{ __('knowledgebase.Edit') }}</a>
                    </div>
                    <div class="card-body">
                        {!! $article->content !!}
                        <hr>
                        {{ $article->tags->pluck('name')->implode(', ') }}
                    </div>
                    <div class="card-footer text-muted">
                        {{ $article->category->name }}
                        <small style="float: right">{{ $article->created_at }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection