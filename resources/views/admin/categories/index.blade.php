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

                        @if(session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session()->get('error') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.categories.store') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="en" class="form-label">{{ __('knowledgebase.TitleEn') }}</label>
                                <input type="text" name="en"
                                       class="form-control @error('en') is-invalid @enderror"
                                       value="{{ old('en') ?? (isset($category) ? $category->name : '') }}">

                                @error('en')
                                    <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ru" class="form-label">{{ __('knowledgebase.TitleRu') }}</label>
                                <input type="text" name="ru"
                                       class="form-control @error('ru') is-invalid @enderror"
                                       value="{{ old('ru') ?? (isset($category) ? $category->name : '') }}">

                                @error('ru')
                                    <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="parent_id" class="form-label">{{ __('knowledgebase.CategoryParent') }}</label>

                                <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                    <option value="" disabled>{{ __('knowledgebase.SelectCategory') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('parent_id') ?? $category) === $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('parent_id')
                                    <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('knowledgebase.AddNew') }}</button>
                        </form>

                        <table class="table mt-5">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('knowledgebase.Title') }}</th>
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
