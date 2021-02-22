@extends('layouts.app-vue')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('account.edit') }}
            </div>

            <div class="card-body">
                <form action="{{ route('account.facilities.update', $facility) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#compatibility_params"
                                       role="tab">{{ __('admin.compatibility_params') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="facility" role="tabpanel">
                                    @include('account.facilities.form_components.facility')
                                </div>
                                <div class="tab-pane fade" id="compatibility_params" role="tabpanel">
                                    @include('account.facilities.form_components.c_params')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-5">
                        <button type="submit" class="btn btn-primary">{{ __('dictionary.Save') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
