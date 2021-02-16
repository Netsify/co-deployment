@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Новая переменная
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.facilities.variables.store') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Имя переменной</label>
                                <input type="text" class="form-control form-control-sm" id="name" name="name"
                                       value="{{ old('name') }}">
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Группа</label>
                                <select name="category" id="category" class="form-control form-control-sm">
                                    <option value="0">Выберите группу</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->getTitle() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Категория</label>
                                <select name="category" id="category" class="form-control form-control-sm">
                                    <option value="0">Выберите категорию</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Тип переменной</label><br>
                                @foreach($var_types as $var_type)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type" id="{{ $var_type }}"
                                               value="{{ $var_type }}">
                                        <label class="form-check-label" for="{{ $var_type }}">{{ $var_type }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row">
                                @foreach(config('app.locales') as $locale)
                                    <div class="col-sm-6 mb-3">
                                        <label for="description_{{ $locale }}" class="form-label">Описание ({{ $locale }})</label>
                                        <textarea name="description[{{ $locale }}]" id="description_{{ $locale }}" rows="3"
                                                  class="form-control form-control-sm">{{ old("description.$locale") }}</textarea>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row">
                                @foreach(config('app.locales') as $locale)
                                    <div class="col-sm-6 mb-3">
                                        <label for="unit_{{ $locale }}" class="form-label">Единица измерения ({{ $locale }})</label>
                                        <input type="text" name="unit[{{ $locale }}]" id="unit_{{ $locale }}"
                                                  class="form-control form-control-sm" value="{{ old("unit.$locale") }}">
                                    </div>
                                @endforeach
                            </div>

                            <div class="row mb-3">
                                <div class="col col-sm-4">
                                    <label for="min_val" class="form-label">Минимальное значение</label>
                                    <input type="number" name="min_val" id="min_val"
                                           class="form-control form-control-sm" value="{{ old('min_val') }}">
                                </div>
                                <div class="col col-sm-4">
                                    <label for="max_val" class="form-label">Максимальное значение</label>
                                    <input type="number" name="max_val" id="max_val"
                                           class="form-control form-control-sm" value="{{ old('max_val') }}">
                                </div>
                                <div class="col col-sm-4">
                                    <label for="default_val" class="form-label">Значение по умолчанию</label>
                                    <input type="number" name="default_val" id="default_val"
                                           class="form-control form-control-sm" value="{{ old('default_val') }}">
                                </div>
                            </div>

                            <button class="btn btn-sm btn-primary">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection