@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('admin_variable.variable_new') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ $route }}" method="post">
                            @csrf
                            @if ($variable->exists)
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('admin_variable.variable_name') }}</label>
                                <input type="text"
                                       class="form-control form-control-sm @error('name') is-invalid @enderror"
                                       id="name" name="name"
                                       value="{{ old('name') ?? $variable->slug }}">
                                @error('name')
                                <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="group" class="form-label">{{ __('admin_variable.variable_group') }}</label>
                                <select name="group" id="group" class="form-control form-control-sm
                                    @error('group') is-invalid @enderror">
                                    <option value="0">{{ __('admin_variable.select_group') }}</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}"
                                            {{ (old('group') ?? $variable->group_id) == $group->id ? 'selected' : '' }}>
                                            {{ $group->getTitle() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('group')
                                <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">{{ __('knowledgebase.Category') }}</label>
                                <select name="category" id="category" class="form-control form-control-sm
                                    @error('category') is-invalid @enderror">
                                    <option value="0">{{ __('knowledgebase.SelectCategory') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ (old('category') ?? $variable->category_of_variable_id) == $category->id
                                            ? 'selected' : '' }}>{{ $category->slug }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">{{ __('admin_variable.variable_type') }}</label><br>
                                @foreach($var_types as $var_type)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('type') is-invalid @enderror" type="radio"
                                               name="type" id="{{ $var_type }}"
                                               value="{{ $var_type }}"
                                            {{ (old('type') ?? $variable->type ) == $var_type ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $var_type }}">{{ $var_type }}</label>
                                        @error('type')
                                        <x-invalid-feedback :message="$message"/>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            <div class="row">
                                @foreach(config('app.locales') as $locale)
                                    <div class="col-sm-6 mb-3">
                                        <label for="description_{{ $locale }}" class="form-label">
                                            {{ __('admin_variable.description') }} ({{ $locale }})</label>
                                        <textarea name="description[{{ $locale }}]" id="description_{{ $locale }}"
                                                  rows="3" class="form-control form-control-sm
                                                  @error('description.'.$locale) is-invalid @enderror">
                                            {{ old("description.$locale") ?? optional($variable->translate($locale))->description }}
                                        </textarea>
                                        @error('description.'.$locale)
                                        <x-invalid-feedback :message="$message"/>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            <div class="row">
                                @foreach(config('app.locales') as $locale)
                                    <div class="col-sm-6 mb-3">
                                        <label for="unit_{{ $locale }}" class="form-label">
                                            {{ __('admin_variable.unit_of_measurement') }} ({{ $locale }})</label>
                                        <input type="text" name="unit[{{ $locale }}]" id="unit_{{ $locale }}"
                                               class="form-control form-control-sm
                                               @error('unit.'.$locale) is-invalid @enderror"
                                               value="{{ old("unit.$locale") ?? optional($variable->translate($locale))->unit }}">
                                        @error('unit.'.$locale)
                                        <x-invalid-feedback :message="$message"/>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            <div class="row mb-3">
                                <div class="col col-sm-4">
                                    <label for="min_val" class="form-label">{{ __('admin_variable.min_value') }}</label>
                                    <input type="number" name="min_val" id="min_val" step="0.01"
                                           class="form-control form-control-sm @error('min_val') is-invalid @enderror"
                                           value="{{ old('min_val') ?? $variable->min_val }}">
                                    @error('min_val')
                                    <x-invalid-feedback :message="$message"/>
                                    @enderror
                                </div>
                                <div class="col col-sm-4">
                                    <label for="max_val" class="form-label">{{ __('admin_variable.max_value') }}</label>
                                    <input type="number" name="max_val" id="max_val" step="0.01"
                                           class="form-control form-control-sm @error('max_val') is-invalid @enderror"
                                           value="{{ old('max_val') ?? $variable->max_val }}">
                                    @error('max_val')
                                    <x-invalid-feedback :message="$message"/>
                                    @enderror
                                </div>
                                <div class="col col-sm-4">
                                    <label for="default_val" class="form-label">
                                        {{ __('admin_variable.default_value') }}
                                    </label>
                                    <input type="number" name="default_val" id="default_val" step="0.01"
                                           class="form-control form-control-sm @error('default_val') is-invalid @enderror" value="{{ old('default_val') ?? $variable->default_val }}">
                                    @error('default_val')
                                    <x-invalid-feedback :message="$message"/>
                                    @enderror
                                </div>
                            </div>

                            <button class="btn btn-sm btn-primary">{{ __('knowledgebase.Save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
