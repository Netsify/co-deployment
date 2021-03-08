@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('account.economic_variables') }}
                <b>{{ __('variable.selected_group') }}: </b> {{ $group->getTitle() }}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col col-sm-3">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                @foreach($groups as $gr)
                                    <li class="list-group-item text-center">
                                        <a href="{{ route('account.variables.list', $gr) }}"
                                           class="btn btn-link">{{ $gr->getTitle() }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col col-sm-9">
                        <form action="{{ route('account.variables.store', $group) }}" method="post">
                            @csrf
                            <table class="table table-sm table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('variable.variable') }}</th>
                                    <th scope="col">{{ __('variable.unit') }}</th>
                                    <th scope="col">{{ __('variable.value') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($variables as $variable)
                                    <tr>
                                        <th scope="row" width="10%">{{ $loop->iteration }}</th>
                                        <td width="60%">{{ $variable->description }}</td>
                                        <td width="20%">{{ $variable->unit }}</td>
                                        <td width="10%">
                                            <input type="number" name="variable[{{ $variable->id }}]"
                                                   step="{{ $variable->type == 'FLOAT' ? 0.01 : 1 }}"
                                                   class="form-control-form-control-sm" value="{{ $variable->value }}">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <button class="btn btn-sm btn-primary">{{ __('dictionary.Save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection