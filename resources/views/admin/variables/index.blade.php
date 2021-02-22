@extends('layouts.app')

@section('content')
    <div class="container" id="variables">
        @{{ msg }}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Переменные для экономической эффективности
                        <div class="btn-toolbar" role="toolbar" style="float: right">
                                <div class="btn-group me-2" role="group">
                                    <a href="{{ route('admin.facilities.variables.create') }}"
                                       class="btn btn-sm btn-success"
                                       style="float: right">Добавить переменную</a>
                                </div>
                                <div class="btn-group me-2" role="group">
                                    <button id="load-xls-file" class="btn btn-sm btn-warning">Добавить из файла</button>
                                </div>

                        </div>
                    </div>

                    <div class="card-body">
                        @foreach($groups as $group)
                            <h5>{{ $group->facilityTypes->pluck('name')->implode(' - ') }}</h5>
                            <table class="table table-sm table-bordered">
                                <thead>
                                <tr>
                                    <th width="20%">Имя переменной</th>
                                    <th width="40%">Описание</th>
                                    <th width="20%">Значение по умолчанию</th>
                                    <th width="20%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($group->variables as $variable)
                                    <tr>
                                        <td>{{ $variable->slug }}</td>
                                        <td>{{ $variable->description }}</td>
                                        <td>{{ $variable->default_val }} {{ $variable->unit }}</td>
                                        <td>
                                            <div class="btn-toolbar" role="toolbar">
                                                <form action="{{ route('admin.facilities.variables.destroy', $variable) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('admin.facilities.variables.edit', $variable) }}"
                                                       class="btn btn-sm btn-info">Редактировать</a>
                                                    <button class="btn btn-sm btn-danger">Удалить</button>
                                                </form>
                                            </div>
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

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/variables.js') }}"></script>
@endsection
