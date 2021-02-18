@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Переменные для экономической эффективности
                        <a href="{{ route('admin.facilities.variables.create') }}" class="btn btn-sm btn-success"
                           style="float: right">Добавить переменную</a>
                    </div>

                    <div class="card-body">
                        @foreach($groups as $group)
                            <p><b>{{ $group->facilityTypes->pluck('name')->implode(' - ') }}</b></p>
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>Имя переменной</th>
                                    <th>Описание</th>
                                    <th>Значение по умолчанию</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($group->variables as $variable)
                                    <tr>
                                        <td>{{ $variable->slug }}</td>
                                        <td>{{ $variable->description }}</td>
                                        <td>{{ $variable->default_value }} {{ $variable->unit }}</td>
                                        <td>
                                            <a href="{{ route('admin.facilities.variables.show', $variable) }}"
                                               class="btn btn-sm btn-info">Редактировать</a>
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