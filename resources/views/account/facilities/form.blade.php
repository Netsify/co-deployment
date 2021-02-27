@extends('layouts.app')

@section('content')
    <div class="container" id="div-facilities">
        <div class="row">
            <div class="col">
                <form action="{{ $route }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if($facility->exists)
                        @method('PUT')
                    @endif
                        <div class="card">
                        <div class="card-header">{{ __('facility.' . ($facility->exists ? 'edit' : 'new') . '_facility') }}
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
                                    @include('account.facilities.form_components.facility')
                                </div>
                                <div class="tab-pane fade" id="compatibility_params" role="tabpanel" v-if="type_id != 0">
                                    @include('account.facilities.form_components.c_params')
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

@section('scripts')
    <script src="{{ asset('js/facilities.js') }}" defer></script>
@endsection
