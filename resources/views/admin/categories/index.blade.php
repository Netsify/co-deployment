@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        {{ __('knowledgebase.Categories') }}
                    </div>

                    <div class="card-body">

                        @if(session()->has('message'))
                            <div class="alert alert-info" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.categories.store') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="name_en" class="form-label">{{ __('knowledgebase.TitleEn') }}</label>
                                <input type="text" name="name_en"
                                       class="form-control @error('name_en') is-invalid @enderror"
                                       value="{{ old('name_en') ?? (isset($category) ? $category->name : '') }}">

                                @error('name_en')
                                    <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name_ru" class="form-label">{{ __('knowledgebase.TitleRu') }}</label>
                                <input type="text" name="name_ru"
                                       class="form-control @error('name_ru') is-invalid @enderror"
                                       value="{{ old('name_ru') ?? (isset($category) ? $category->name : '') }}">

                                @error('name_ru')
                                    <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="parent_category" class="form-label">{{ __('knowledgebase.CategoryParent') . ' ' . __('knowledgebase.Optional') }}</label>

                                <select name="parent_category" class="form-select @error('parent_category') is-invalid @enderror">
                                    <option hidden></option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('parent_category') ?? $category) === $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('parent_category')
                                    <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('knowledgebase.AddNew') }}</button>
                        </form>

                        <table class="table mt-5">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('knowledgebase.Title') }}</th>
                                    <th scope="col">{{ __('knowledgebase.CategoryParent') }}</th>
                                    <th scope="col">{{ __('knowledgebase.ArticlesCount') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>

                            <tbody>
                                <form method="POST">
                                    @method('DELETE')
                                    @csrf
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->parent->name ?? '' }}</td>
                                            <td>{{ $category->articles()->count() }}</td>
                                            <td>
                                                <button type="submit" class="btn btn-danger btn-sm" formaction="{{ route('admin.categories.destroy', $category) }}">
                                                    {{ __('knowledgebase.delete') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </form>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
