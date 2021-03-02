@extends('layouts.app-vue')

@section('vue-content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('account.edit') }}
            </div>

            @if (session()->has('message'))
                <div class="alert alert-info d-flex align-items-center justify-content-center my-2">
                    {{ session('message') }}
                </div>
            @endif

            <div class="card-body">
                <form action="{{ route('account.facilities.update', $facility) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3">
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
                                    @include('account.facilities.form_components_old.facility')
                                </div>
                                <div class="tab-pane fade" id="compatibility_params" role="tabpanel">
                                    @include('account.facilities.form_components_old.c_params')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">{{ __('dictionary.Save') }}</button>
                    </div>
                </form>

                @facilityFilesNotDeleted($facility)
                <div class="my-4">
                    <label class="form-label">{{ __('knowledgebase.Files') }}</label>

                    <form method="POST">
                        @method('DELETE')
                        @csrf
                        @foreach($facility->files as $file)
                            <div class="mb-1">
                                <a href="{{ $file->link }}" target="_blank">{{ $file->name }}</a>

                                @can('userFacilityHasFile', [$facility, $file])
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            formaction="{{ route('account.facilities.delete_file', [$facility, $file]) }}">
                                        Удалить файл
                                    </button>
                                @endcan
                            </div>
                        @endforeach
                    </form>
                </div>
                @endfacilityFilesNotDeleted

            </div>
        </div>
    </div>
@endsection
