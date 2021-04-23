@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-sm-2">
                @include('admin.sidebar')
            </div>
            <div class="col col-sm-10">
                <div class="card">
                    <div class="card-header">
                        {{ __('admin_variable.economic_efficiency_variables') }}
                        <div class="btn-toolbar" role="toolbar" style="float: right">
                            <div class="btn-group me-2" role="group">
                                <a href="{{ route('admin.facilities.variables.create') }}"
                                   class="btn btn-sm btn-success"
                                   style="float: right">{{ __('admin_variable.add_variable') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @foreach($groups as $group)
                            <h5>{{ $group->getTitle() }}</h5>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_variable.variable_name') }}</th>
                                        <th>{{ __('admin_variable.description') }}</th>
                                        <th>{{ __('admin_variable.default_value') }}</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($group->variables as $variable)
                                    <tr>
                                        <td>{{ $variable->slug }}</td>
                                        <td>{{ $variable->description }}</td>
                                        <td>{{ $variable->default_val }} {{ $variable->unit }}</td>
                                        <td>
                                            <a href="{{ route('admin.facilities.variables.edit', $variable) }}"
                                               class="btn btn-sm btn-success">
                                                {{ __('knowledgebase.Edit') }}
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.facilities.variables.destroy', $variable) }}"
                                                  method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    {{ __('knowledgebase.delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
