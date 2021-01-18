@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-sm-2">
                @include('admin.sidebar')
            </div>
            <div class="col col-sm-10">
                <a href="{{ route('admin.facilities.compatibility_params.create') }}" class="btn btn-sm btn-success">{{ __('compatibility_param.add') }}</a>
                <hr>
                <div class="card ">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs pull-right"  id="myTab" role="tablist">
                            @foreach($param_groups as $group)
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->iteration == 1 ? 'active' : '' }}" data-toggle="tab" href="#{{ $group->slug }}" role="tab">{{ $group->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            @foreach($param_groups as $group)
                            <div class="tab-pane fade {{ $loop->iteration == 1 ? 'show active' : '' }}" id="{{ $group->slug }}" role="tabpanel">
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('compatibility_param.param_name') }}</th>
                                        <th scope="col">{{ __('compatibility_param.min_val') }}</th>
                                        <th scope="col">{{ __('compatibility_param.max_val') }}</th>
                                        <th scope="col">{{ __('compatibility_param.default_val') }}</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($group->params as $param)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $param->name }}</td>
                                        <td>{{ $param->min_val }}</td>
                                        <td>{{ $param->max_val }}</td>
                                        <td>{{ $param->default_val }}</td>
                                        <td>
                                            <a href="{{ route('admin.facilities.compatibility_params.show', $param) }}" class="btn btn-sm btn-info">{{ __('compatibility_param.more') }}</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection