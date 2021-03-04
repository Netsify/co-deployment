@extends('layouts.app')

@section('content')
    <div class="container" id="variables">
        <div class="card">
            <div class="card-header">
                {{ __('account.economic_variables') }}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col col-sm-3">
                        <div class="btn-group-vertical" role="group" aria-label="Basic radio toggle button group">
                            @foreach($groups as $group)
                                <input type="radio" class="btn-check" name="btnradio" id="{{ $group->id }}"
                                       value="{{ $group->id }}"
                                       autocomplete="off"
                                       @click="getVars"
                                >
                                <label class="btn btn-outline-danger" for="{{ $group->id }}">{{ $group->getTitle() }}</label>
                            @endforeach
                        </div>
                    </div>
                    <div class="col col-sm-9">@{{ id }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/variables.js') }}" defer></script>
@endsection