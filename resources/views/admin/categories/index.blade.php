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
                                <label for="title" class="form-label">{{ __('knowledgebase.Title') }}</label>
                                <input type="text" name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title" value="{{ old('title') ?? (isset($category) ? $category->title : '') }}">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">{{ __('knowledgebase.Category') }}</label>
                                <select name="category" id="category" class="form-select @error('category') is-invalid @enderror">
                                    <option value="0" disabled>{{ __('knowledgebase.SelectCategory') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category') ?? $category) === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
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
