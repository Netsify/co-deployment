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
                            @forelse($group->variables as $variable)
                               {{ $variable->description }}
                            @empty
                                Переменные не найдены
                            @endforelse
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection