@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <b>{{ __('attention.title') }}</b>
            </div>
            <div class="card-body">
                <p class="text-justify">{{ __('attention.p1') }}</p>

                <p class="text-justify">{{ __('attention.p2') }}</p>
                <p class="text-justify">
                    <a href="https://x1ptux.axshare.com/#id=ioz8vs&p=knowledge_base-ru&g=1" target="_blank"
                       class="btn btn-link">{{ __('attention.link') }}</a>
                </p>
            </div>
        </div>
    </div>
@endsection