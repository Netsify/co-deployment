@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>{{ __('admin.welcome_to_admin_panel') }}</h4>
        <div class="card">
            <div class="card-header">
                {{ __('compatibility_param.new_param') }}
            </div>
            <div class="card-body">
                <form action="{{ route('admin.facilities.compatibility_params.store') }}" method="post">
                    @csrf
                    <div class="row mb-3">
                        @foreach(config('app.locales') as $locale)
                            <div class="col col-sm-6">
                                <label for="name_{{ $locale }}"
                                       class="form-label">{{ __("compatibility_param.name_$locale") }}</label>
                                <input type="text"
                                       class="form-control form-control-sm @error('name.'.$locale) is-invalid @enderror"
                                       id="name_{{ $locale }}" name="name[{{ $locale }}]"
                                       value="{{ old("name.$locale") }}">
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
                                <option value="{{ $group->id }}" {{ old('group') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                            @endforeach
                        </select>
                        @error("group")
                        <x-invalid-feedback :message="$message"/>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        @foreach(['min_val', 'max_val', 'default_val'] as $value)
                        <div class="col col-sm-4">
                            <label for="{{ $value }}" class="form-label">{{ __("compatibility_param.$value") }}</label>
                            <input type="number" min="0" class="form-control form-control-sm @error($value) is-invalid @enderror" id="{{ $value }}"
                                   name="{{ $value }}">
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
                                                      class="form-control form-control-sm"></textarea>
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
                                                      class="form-control form-control-sm"></textarea>
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
                                                      class="form-control form-control-sm"></textarea>
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
                                                      class="form-control form-control-sm"></textarea>
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
                                                      class="form-control form-control-sm"></textarea>
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