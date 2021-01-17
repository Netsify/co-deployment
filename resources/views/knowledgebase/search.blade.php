@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('knowledgebase.KB') }}</h5>
                    </div>

                    <div class="card-body">
                        <form method="get">
                            <div class="input-group rounded mb-3">
                                <input type="search" name="content" class="form-control rounded"
                                       placeholder="{{ __('knowledgebase.Search') }}"
                                       aria-label="Search" aria-describedby="search-addon" />
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">{{ __('knowledgebase.Category') }}</label>
                                <select name="category" id="category"
                                        class="form-select @error('category') is-invalid @enderror">
                                    <option value="" disabled>{{ __('knowledgebase.SelectCategory') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (!isset($article) ? old('category') : $article->category->id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                @error('category')
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

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">{{ __('knowledgebase.Search') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
