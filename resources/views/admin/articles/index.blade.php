@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-sm-3">
                @include('admin.articles.sidebar')
            </div>
            <div class="col col-sm-9">
                <h4>{{ $title }}</h4>

                @forelse($articles as $article)
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col col-sm-6">
                                    <h5 class="card-title">{{ $article->title }}</h5>
                                </div>
                                <div class="col col-sm-6">
                                    <div class="btn-toolbar" style="float: right" role="toolbar"
                                         aria-label="Toolbar with button groups">
                                        <form action="{{ route('admin.articles.verify', $article) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            @articleNotPublished($article)
                                            <div class="btn-group me-2" role="group" aria-label="First group">
                                                <button type="submit" name="publicate"
                                                        class="btn btn-success btn-sm">{{ __('knowledgebase.publicate') }}</button>
                                            </div>
                                            @endarticleNotPublished
                                        </form>
                                        @articleNotDeleted($article)
                                        <x-delete-button :article="$article" route="admin.articles.destroy"/>
                                        @endarticleNotDeleted
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-muted float-right">{{ $article->user->full_name }}<x-icon-verified
                                    :user="$article->user"></x-icon-verified></p>
                            <p>{!! $article->preview !!}</p>

                            <a href="{{ route('admin.articles.show', $article) }}"
                               class="card-link">{{ __('knowledgebase.view') }}</a>
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
        </div>
    </div>
@endsection
