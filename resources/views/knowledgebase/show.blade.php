@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-sm-3">
                @include('knowledgebase.categories.sidebar')
            </div>
            <div class="col col-sm-9">
                @if (session()->has('success'))
                    <x-alert class="success" message="{{ session()->get('success') }}"/>
                @endif

                <div class="card">
                    <div class="card-header">
                        {{ $article->title }}
                        @can('update', $article)
                            <a href="{{ route(($fromAdminPanel ? 'admin.' : '' ) . 'articles.edit', $article) }}"
                               class="btn btn-sm btn-success" style="float: right">
                                {{ __('knowledgebase.Edit') }}
                            </a>
                        @endcan
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
                        <div class="d-flex justify-content-between">
                            {{ $tags }}

                            @can('delete', $article)
                                <x-delete-button :article="$article" route="articles.destroy"/>
                            @endcan
                        </div>
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
