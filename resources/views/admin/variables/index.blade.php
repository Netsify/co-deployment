@extends('layouts.app')

@section('content')
    <div class="container" id="variables">
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
                                <button id="load-xls-file" class="btn btn-sm btn-warning"
                                        @click="modalVisibility = true">Добавить из файла
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="card-body">
                        @foreach($groups as $group)
                            <h5>{{ $group->getTitle() }}</h5>
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


        <div class="modal fade show" style="display:block;" v-if="modalVisibility" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('admin.facilities.variables.excel_store') }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Загрузить</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    @click="modalVisibility = false"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="group" class="form-label">Группа</label>
                                <select name="group" id="group" class="form-control">
                                    <option value="0">Выберите группу</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->getTitle() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Выберите файл</label>
                                <input class="form-control" type="file" id="formFile" name="file"
                                       accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Загрузить</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                    @click="modalVisibility = false">Закрыть
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show" v-if="modalVisibility"></div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/variables.js') }}"></script>
@endsection
