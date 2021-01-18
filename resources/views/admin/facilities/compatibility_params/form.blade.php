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
                    @isset($compatibilityParam)
                        @method('PUT')
                    @endisset
                    <div class="row mb-3">
                        @foreach(config('app.locales') as $locale)
                            <div class="col col-sm-6">
                                <label for="name_{{ $locale }}"
                                       class="form-label">{{ __("compatibility_param.name_$locale") }}</label>
                                <input type="text"
                                       class="form-control form-control-sm @error('name.'.$locale) is-invalid @enderror"
                                       id="name_{{ $locale }}" name="name[{{ $locale }}]"
                                       value="{{ old("name.$locale") ?? (isset($compatibilityParam) ? $compatibilityParam->translate($locale)->name : "") }}">
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
                                <option value="{{ $group->id }}" {{ old('group') ??  (isset($compatibilityParam) ? $compatibilityParam->group_id : '') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
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
                                       value="{{ old($value) ?? (isset($compatibilityParam) ? $compatibilityParam->$value : '') }}">
                                @error($value)
                                <x-invalid-feedback :message="$message"/>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                    <hr>

                    <div class="row sm-3">
                        <label for="road_description"
                               class="col-sm-2 col-form-label">{{ __('compatibility_param.road_description') }}</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @foreach(config('app.locales') as $locale)
                                    <div class="col-sm-6">
                                        <div class="sm-3">
                                            <label for="road_desc_{{ $locale }}"
                                                   class="form-label">{{ __('compatibility_param.'.$locale) }}</label>
                                            <textarea name="road_desc[{{ $locale }}]" id="road_desc_{{ $locale }}"
                                                      class="form-control form-control-sm @error('road_desc.'.$locale) is-invalid @enderror">{{ old("road_desc.$locale") ?? (isset($compatibilityParam) ? $compatibilityParam->translate($locale)->description_road : "") }}</textarea>
                                            @error("road_desc.$locale")
                                            <x-invalid-feedback :message="$message"/>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row sm-3">
                        <label for="railway_description"
                               class="col-sm-2 col-form-label">{{ __('compatibility_param.railway_description') }}</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @foreach(config('app.locales') as $locale)
                                    <div class="col-sm-6">
                                        <div class="sm-3">
                                            <label for="railway_desc_{{ $locale }}"
                                                   class="form-label">{{ __('compatibility_param.'.$locale) }}</label>
                                            <textarea name="railway_desc[{{ $locale }}]" id="railway_desc_{{ $locale }}"
                                                      class="form-control form-control-sm @error('railway_desc.'.$locale) is-invalid @enderror">{{ old("railway_desc.$locale") ?? (isset($compatibilityParam) ? $compatibilityParam->translate($locale)->description_railway : "") }}</textarea>
                                            @error("railway_desc.$locale")
                                            <x-invalid-feedback :message="$message"/>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row sm-3">
                        <label for="energy_description"
                               class="col-sm-2 col-form-label">{{ __('compatibility_param.energy_description') }}</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @foreach(config('app.locales') as $locale)
                                    <div class="col-sm-6">
                                        <div class="sm-3">
                                            <label for="energy_desc_{{ $locale }}"
                                                   class="form-label">{{ __('compatibility_param.'.$locale) }}</label>
                                            <textarea name="energy_desc[{{ $locale }}]" id="energy_desc_{{ $locale }}"
                                                      class="form-control form-control-sm @error('energy_desc.'.$locale) is-invalid @enderror">{{ old("energy_desc.$locale")  ?? (isset($compatibilityParam) ? $compatibilityParam->translate($locale)->description_energy : "")}}</textarea>
                                            @error("energy_desc.$locale")
                                            <x-invalid-feedback :message="$message"/>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row sm-3">
                        <label for="ict_description"
                               class="col-sm-2 col-form-label">{{ __('compatibility_param.ict_description') }}</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @foreach(config('app.locales') as $locale)
                                    <div class="col-sm-6">
                                        <div class="sm-3">
                                            <label for="ict_desc_{{ $locale }}"
                                                   class="form-label">{{ __('compatibility_param.'.$locale) }}</label>
                                            <textarea name="ict_desc[{{ $locale }}]" id="ict_desc_{{ $locale }}"
                                                      class="form-control form-control-sm @error('ict_desc.'.$locale) is-invalid @enderror">{{ old("ict_desc.$locale") ?? (isset($compatibilityParam) ? $compatibilityParam->translate($locale)->description_ict : "")}}</textarea>
                                            @error("ict_desc.$locale")
                                            <x-invalid-feedback :message="$message"/>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="other_description"
                               class="col-sm-2 col-form-label">{{ __('compatibility_param.other_description') }}</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @foreach(config('app.locales') as $locale)
                                    <div class="col-sm-6">
                                        <div class="sm-3">
                                            <label for="other_desc_{{ $locale }}"
                                                   class="form-label">{{ __('compatibility_param.'.$locale) }}</label>
                                            <textarea name="other_desc[{{ $locale }}]" id="other_desc_{{ $locale }}"
                                                      class="form-control form-control-sm @error('other_desc.'.$locale) is-invalid @enderror">{{ old("other_desc.$locale") ?? (isset($compatibilityParam) ? $compatibilityParam->translate($locale)->description_other : "") }}</textarea>
                                            @error("other_desc.$locale")
                                            <x-invalid-feedback :message="$message"/>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('compatibility_param.add') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection