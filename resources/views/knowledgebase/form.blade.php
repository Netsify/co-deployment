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
                            {{ __('knowledgebase.new_article') }}
                        @endisset
                    </div>

                    <div class="card-body">
                        @if(session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <form action="{{ isset($article) ? route('articles.update', $article) : route('articles.store') }}"
                              method="post" enctype="multipart/form-data">
                            @csrf
                            @isset($article)
                                @method('PUT')
                            @endisset

                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('knowledgebase.Title') }}</label>
                                <input type="text" name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title" value="{{ old('title') ?? (isset($article) ? $article->title : '') }}">

                                @error('title')
                                <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">{{ __('knowledgebase.Category') }}</label>
                                <select name="category" id="category"
                                        class="form-select @error('category') is-invalid @enderror">
                                    <option value="0" disabled>{{ __('knowledgebase.SelectCategory') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (!isset($article) ? old('category') : $article->category->id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                @error('category')
                                <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">{{ __('knowledgebase.Content') }}</label>
                                <textarea name="content" id="content" cols="30" rows="10"
                                          class="@error('content') is-invalid @enderror">
                                    {{ old('content') ?? (isset($article) ? $article->content : '') }}
                                </textarea>

                                @error('content')
                                <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tag" class="form-label">{{ __('knowledgebase.Tag') }}</label>
                                <select name="tag[]" id="tag" class="form-select" multiple>
                                    <option value="0" disabled>{{ __('knowledgebase.SelectTags') }}</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" {{ isset($article) && $article->tags->contains($tag) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <input type="file" name="files[]" class="form-control @error('files') is-invalid @enderror" multiple>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('knowledgebase.Save') }}</button>
                        </form>

                        @isset($article)
                            @articleFilesNotDeleted($article)
                                <div class="my-4">
                                    <label class="form-label">{{ __('knowledgebase.Files') }}</label>

                                    <form method="POST">
                                        @method('DELETE')
                                        @csrf
                                        @foreach($article->files as $file)
                                            <div class="mb-1">
                                                <a href="{{ $file->link }}" target="_blank">{{ $file->name }}</a>
                                                <button type="submit" class="btn btn-danger btn-sm" formaction="{{ route('admin.articles.delete_file', $file) }}">
                                                    Удалить файл
                                                </button>
                                            </div>
                                        @endforeach
                                    </form>
                                </div>
                            @endarticleFilesNotDeleted
                        @endisset

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
