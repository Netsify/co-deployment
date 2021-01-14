@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>{{ __('admin.welcome_to_admin_panel') }}</h4>
        <div class="card">
            <div class="card-header">
               {{ __('compatibility_param.new_param') }}
            </div>
            <div class="card-body">
                <form>
                    <div class="row sm-3">
                        <label for="name_ru" class="col-sm-2 col-form-label">{{ __('compatibility_param.name_ru') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" id="name_ru" name="name_ru">
                        </div>
                    </div>

                    <div class="row sm-3">
                        <label for="name_en" class="col-sm-2 col-form-label">{{ __('compatibility_param.name_en') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" id="name_en" name="name_en">
                        </div>
                    </div>

                    <div class="row sm-3">
                        <label for="group" class="col-sm-2 col-form-label">{{ __('compatibility_param.group') }}</label>
                        <div class="col-sm-10">
                            <select name="group" id="group" class="form-control form-control-sm">
                                <option value="">__('compatibility_param.select_group')</option>
                                @foreach($param_groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
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


                    <button type="submit" class="btn btn-primary">Sign in</button>
                </form>
            </div>
        </div>
    </div>
@endsection