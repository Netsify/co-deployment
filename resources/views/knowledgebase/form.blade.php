@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        @isset($article)
                            {{ __('knowledgebase.EditArticle') }}
                        @else
                            {{ __('knowledgebase.NewArticle') }}
                        @endisset
                    </div>

                    <div class="card-body">
                        @if(session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <form action="{{ route('articles.store') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('knowledgebase.Title') }}</label>
                                <input type="text" name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title" value="{{ old('title') ?? (isset($article) ? $article->title : '') }}">

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">{{ __('knowledgebase.Category') }}</label>
                                <select name="category" id="category"
                                        class="form-select @error('category') is-invalid @enderror">
                                    <option value="0" disabled>{{ __('knowledgebase.SelectCategory') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category')  ?? isset($article) ? $article->category->id : '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">{{ __('knowledgebase.Content') }}</label>
                                <textarea name="content" id="content" cols="30" rows="10"
                                          class="@error('content') is-invalid @enderror">
                                    {{ old('content') ?? (isset($article) ? $article->content : '') }}
                                </textarea>

                                @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                {{--@dump($article->tags->pluck('id')->toArray())--}}
                            </div>

                            <div class="mb-3">
                                <label for="tag" class="form-label">{{ __('knowledgebase.Tag') }}</label>
                                <select name="tag[]" id="tag" class="form-select" multiple>
                                    <option value="0" disabled>{{ __('knowledgebase.SelectTags') }}</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}"
                                        {{ in_array($tag->id, $article->tags->pluck('id')->toArray()) ? 'selected' : '' }}
                                        >{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('knowledgebase.Save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript">
            CKEDITOR.replace('content');
        </script>
    </div>
@endsection