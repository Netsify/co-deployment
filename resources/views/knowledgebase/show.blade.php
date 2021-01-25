@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        {{ $article->title }}
                        <div class="btn-group" role="group" style="float: right">
                            @can('update', $article)
                                <a href="{{ route(($fromAdminPanel ? 'admin.' : '' ) . 'articles.edit', $article) }}"
                                   class="btn btn-sm btn-success">{{ __('knowledgebase.Edit') }}</a>
                            @endcan
                            @can('delete', $article)
                                    <x-delete-button :article="$article" route="articles.destroy"/>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        {!! $article->content !!}

                        @isset($article)
                            <div class="mb-4">
                                <label>{{ __('knowledgebase.Files') }}</label>

                                @foreach($article->files as $file)
                                    <div class="mb-1">
                                        <a href="{{ $file->link }}" target="_blank">{{ $file->name }}</a>
                                    </div>
                                @endforeach
                            </div>
                        @endisset

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
