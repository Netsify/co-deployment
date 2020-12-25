@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        {{ $article->title }}
                        <div class="btn-group" role="group" style="float: right">
                            <form action="{{ route('articles.destroy', $article) }}" method="POST">
                                <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-success">{{ __('knowledgebase.Edit') }}</a>
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"
                                        style="float: right">{{ __('knowledgebase.Delete') }}</button>
                            </form>
                        </div>
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