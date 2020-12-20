@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('knowledgebase.NewArticle') }}</div>

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
                                <input type="text" name="title" class="form-control" id="title">
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">{{ __('knowledgebase.Category') }}</label>
                                <select name="category" id="category" class="form-select">
                                    <option value="0" disabled>{{ __('knowledgebase.SelectCategory') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">{{ __('knowledgebase.Content') }}</label>
                                <textarea name="content" id="content" cols="30" rows="10"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="tag" class="form-label">{{ __('knowledgebase.Tag') }}</label>
                                <select name="tag[]" id="tag" class="form-select" multiple>
                                    <option value="0" disabled>{{ __('knowledgebase.SelectTags') }}</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
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