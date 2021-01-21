@extends('layouts.app')

@section('title',
(isset($compatibilityParam) ? __("compatibility_param.edit_parameter") : __("compatibility_param.new_param")))

@section('content')
    <div class="container">
        <h4>{{ __('admin.welcome_to_admin_panel') }}</h4>
        <div class="card">
            <div class="card-header">
                {{ __('compatibility_param.new_param') }}
            </div>
            <div class="card-body">
                <form action="{{ $form_action }}" method="post">
                    @csrf
                    @if($compatibilityParam->exists)
                        @method('PUT')
                    @endif
                    <div class="row mb-3">
                        @foreach(config('app.locales') as $locale)
                            <div class="col col-sm-6">
                                <label for="name_{{ $locale }}"
                                       class="form-label">{{ __("compatibility_param.name_$locale") }}</label>
                                <input type="text"
                                       class="form-control form-control-sm @error('name.'.$locale) is-invalid @enderror"
                                       id="name_{{ $locale }}" name="name[{{ $locale }}]"
                                       value="{{ old("name.$locale") ?? ($compatibilityParam->exists ? $compatibilityParam->translate($locale)->name : '') }}">
                                @error("name.$locale")
                                <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label for="group" class="form-label">{{ __('compatibility_param.group') }}</label>
                        <select name="group" id="group"
                                class="form-control form-control-sm @error('group') is-invalid @enderror">
                            <option value="">{{ __('compatibility_param.select_group') }}</option>
                            @foreach($param_groups as $group)
                                <option value="{{ $group->id }}" {{ (old('group') ??  ($compatibilityParam->exists ? $compatibilityParam->group_id : '')) == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                            @endforeach
                        </select>
                        @error("group")
                        <x-invalid-feedback :message="$message"/>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        @foreach(['min_val', 'max_val', 'default_val'] as $value)
                            <div class="col col-sm-4">
                                <label for="{{ $value }}"
                                       class="form-label">{{ __("compatibility_param.$value") }}</label>
                                <input type="number" min="0"
                                       class="form-control form-control-sm @error($value) is-invalid @enderror"
                                       id="{{ $value }}"
                                       name="{{ $value }}"
                                       value="{{ old($value) ?? ($compatibilityParam->exists ? $compatibilityParam->$value : '') }}">
                                @error($value)
                                <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                    <hr>

                    @foreach($facility_types as $type)
                        <div class="row sm-3">
                            <label for="{{ $type->slug }}_description"
                                   class="col-sm-2 col-form-label">{{ __("compatibility_param.{$type->slug}_description") }}</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    @foreach(config('app.locales') as $locale)
                                        <div class="col-sm-6">
                                            <div class="sm-3">
                                                <label for="{{ $type->slug }}_desc_{{ $locale }}"
                                                       class="form-label">{{ __('compatibility_param.'.$locale) }}</label>
                                                <textarea name="{{ $type->slug }}_desc[{{ $locale }}]" id="{{ $type->slug }}_desc_{{ $locale }}"
                                                          class="form-control form-control-sm @error($type->slug.'_desc.'.$locale) is-invalid @enderror">{{ old("{$type->slug}_desc.$locale") ?? ($compatibilityParam->exists ? $compatibilityParam->translate($locale)->{"description_".$type->slug} : "") }}</textarea>
                                                @error("{$type->slug}_desc.$locale")
                                                <x-invalid-feedback :message="$message"/>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-primary">{{ __('compatibility_param.add') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection