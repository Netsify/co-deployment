@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-sm-3">
                @include('knowledgebase.categories.sidebar')
            </div>
            <div class="col col-sm-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('knowledgebase.KB') }}</h5>
                    </div>

                    <div class="card-body">
                        <form method="GET">
                            <div class="input-group rounded mb-3">
                                <input type="search" name="content" class="form-control rounded"
                                       placeholder="{{ __('knowledgebase.Search') }}"
                                       aria-label="Search" aria-describedby="search-addon"
                                       value="{{ request('content') }}"/>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">{{ __('knowledgebase.Category') }}</label>
                                <select name="category" id="category" class="form-select ">
                                    <option value="">{{ __('knowledgebase.SelectCategory') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                {{ $category->id == request()->input('category') ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tag" class="form-label">{{ __('knowledgebase.Tag') }}</label>
                                <select name="tag[]" id="tag" class="form-select" multiple>
                                    <option value="">{{ __('knowledgebase.SelectTags') }}</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}"
                                        @if (request()->input('tag'))
                                            {{ in_array($tag->id, request()->input('tag')) ? 'selected' : '' }}
                                                @endif
                                        >
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">{{ __('knowledgebase.Search') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                @isset($articles)
                    <div class="mt-4">
                        @if ($articles->count() > 0)
                            <x-alert class="info"
                                     message="{{ __('knowledgebase.found', ['count' => $articles->count()]) }}"/>
                        @endif

                        @forelse($articles as $article)
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="card-title">{{ $article->title }}</h5>
                                </div>
                                <div class="card-body">
                                    <p>{{ $article->preview  }}</p>

                                    <a href="{{ route('articles.show', $article) }}"
                                       class="card-link">{{ __('knowledgebase.view') }}</a>
                                </div>
                                <div class="card-footer text-muted">
                                    {{ $article->created_at }}
                                </div>
                            </div>
                        @empty
                            <x-alert class="warning" message="{{ __('knowledgebase.articles_not_found') }}"/>
                        @endforelse
                    </div>
                @endisset
            </div>
        </div>
    </div>
@endsection
