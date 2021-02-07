@extends('layouts.app-vue')

@section('vue-content')
    <div class="container">
        <div class="row">
            <div class="col">
                <form action="{{ $route }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">{{ __('facility.new_facility') }}
                            <span v-if="type_id != 0">
                                <b>{{ __('facility.type') }}</b> @{{ type_name }}
                            </span>
                            <ul class="nav nav-tabs card-header-tabs pull-right" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#facility"
                                       role="tab">{{ __('facility.facility') }}</a>
                                </li>
                                <li class="nav-item" v-if="type_id != 0">
                                    <a class="nav-link" data-toggle="tab" href="#compatibility_params"
                                       role="tab">{{ __('admin.compatibility_params') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="facility" role="tabpanel">
                                    @include('facilities.form_components.facility')
                                </div>
                                <div class="tab-pane fade" id="compatibility_params" role="tabpanel">
                                    @include('facilities.form_components.c_params')
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">{{ __('facility.create_facility') }}</button>
                </form>
            </div>
        </div>
@endsection