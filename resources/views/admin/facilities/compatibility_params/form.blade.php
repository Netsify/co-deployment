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
                        <div class="col col-sm-6">
                            <label for="name_ru" class="form-label">{{ __('compatibility_param.name_ru') }}</label>
                            <input type="text" class="form-control form-control-sm" id="name_ru" name="name_ru">
                        </div>
                        <div class="col col-sm-6">
                            <label for="name_en" class="form-label">{{ __('compatibility_param.name_en') }}</label>
                            <input type="text" class="form-control form-control-sm" id="name_en" name="name_en">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="group" class="form-label">{{ __('compatibility_param.group') }}</label>
                            <select name="group" id="group" class="form-control form-control-sm">
                                <option value="">__('compatibility_param.select_group')</option>
                                @foreach($param_groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-sm-4">
                            <label for="min_val" class="form-label">{{ __('compatibility_param.min_val') }}</label>
                            <input type="number" min="0" class="form-control form-control-sm" id="min_val" name="min_val">
                        </div>
                        <div class="col col-sm-4">
                            <label for="max_val" class="form-label">{{ __('compatibility_param.max_val') }}</label>
                            <input type="number" min="0" class="form-control form-control-sm" id="max_val" name="max_val">
                        </div>
                        <div class="col col-sm-4">
                            <label for="default_val" class="form-label">{{ __('compatibility_param.default_val') }}</label>
                            <input type="number"  min="0" class="form-control form-control-sm" id="default_val" name="default_val">
                        </div>
                    </div>
                    <hr>

                    <div class="row sm-3">
                        <label for="road_description" class="col-sm-2 col-form-label">{{ __('compatibility_param.road_description') }}</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="sm-3">
                                        <label for="road_desc_ru" class="form-label">{{ __('compatibility_param.ru') }}</label>
                                        <textarea name="road_desc_ru" id="road_desc_ru" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="sm-3">
                                        <label for="road_desc_en" class="form-label">{{ __('compatibility_param.en') }}</label>
                                        <textarea name="road_desc_en" id="road_desc_en" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row sm-3">
                        <label for="railway_description" class="col-sm-2 col-form-label">{{ __('compatibility_param.railway_description') }}</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="sm-3">
                                        <label for="railway_desc_ru" class="form-label">{{ __('compatibility_param.ru') }}</label>
                                        <textarea name="railway_desc_ru" id="railway_desc_ru" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="sm-3">
                                        <label for="railway_desc_en" class="form-label">{{ __('compatibility_param.en') }}</label>
                                        <textarea name="railway_desc_en" id="railway_desc_en" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row sm-3">
                        <label for="energy_description" class="col-sm-2 col-form-label">{{ __('compatibility_param.energy_description') }}</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="sm-3">
                                        <label for="energy_desc_ru" class="form-label">{{ __('compatibility_param.ru') }}</label>
                                        <textarea name="energy_desc_ru" id="energy_desc_ru" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="sm-3">
                                        <label for="energy_desc_en" class="form-label">{{ __('compatibility_param.en') }}</label>
                                        <textarea name="energy_desc_en" id="energy_desc_en" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row sm-3">
                        <label for="ict_description" class="col-sm-2 col-form-label">{{ __('compatibility_param.ict_description') }}</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="sm-3">
                                        <label for="ict_desc_ru" class="form-label">{{ __('compatibility_param.ru') }}</label>
                                        <textarea name="ict_desc_ru" id="ict_desc_ru" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="sm-3">
                                        <label for="ict_desc_en" class="form-label">{{ __('compatibility_param.en') }}</label>
                                        <textarea name="ict_desc_en" id="ict_desc_en" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="other_description" class="col-sm-2 col-form-label">{{ __('compatibility_param.other_description') }}</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="sm-3">
                                        <label for="other_desc_ru" class="form-label">{{ __('compatibility_param.ru') }}</label>
                                        <textarea name="other_desc_ru" id="other_desc_ru" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="sm-3">
                                        <label for="other_desc_en" class="form-label">{{ __('compatibility_param.en') }}</label>
                                        <textarea name="other_desc_en" id="other_desc_en" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('compatibility_param.add') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection