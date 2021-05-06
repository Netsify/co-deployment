@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($toolbar_items as $item)
                <div class="col col-sm-4 mb-5">
                    <a href="{{ route($item['link']) }}" class="btn btn-outline-info">
                        <div class="card" style="width: 21rem">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <span class="icon-{{ $item['icon'] }}" style="font-size: 100px"></span>
                                    </div>
                                    <div class="col-sm-9" style="padding-top: 25px">
                                        <h4>{{ __($item['name']) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
