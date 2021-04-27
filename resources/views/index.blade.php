@extends('layouts.app')

@section('styles')
    <style>
        #u6347 {
            border-width: 0px;
            position: relative;
            left: 0px;
            top: 0px;
            width: 0px;
            height: 0px;
        }
        #u6348 {
            border-width: 0px;
            position: absolute;
            left: 39px;
            /*top: 431px;*/
            width: 650px;
            height: 431px;
            display: flex;
            opacity: 0.7;
        }
        .ax_default {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-style: normal;
            font-size: 24px;
            letter-spacing: normal;
            color: #333333;
            vertical-align: none;
            text-align: center;
            line-height: normal;
            text-transform: none;
        }
        #u6348_img {
            border-width: 0px;
            position: absolute;
            left: 0px;
            top: 0px;
            width: 660px;
            height: 441px;
        }
        #u6348 .text {
            position: absolute;
            align-self: center;
            padding: 12px 20px 12px 20px;
            box-sizing: border-box;
            width: 100%;
        }
        #u6348_text {
            border-width: 0px;
            word-wrap: break-word;
            text-transform: none;
            visibility: hidden;
        }
        #u6349 {
            border-width: 0px;
            position: relative;
            left: 148px;
            top: 575px;
            width: 433px;
            height: 144px;
            display: flex;
            font-size: 25px;
            color: #000000;
            text-align: center;
            word-wrap: break-word;
        }
        .label {
            /*font-size: 14px;*/
            /*text-align: justify;*/
            word-wrap: break-word;
        }
        #u6349_img {
            border-width: 0px;
            position: absolute;
            left: 0px;
            top: 0px;
            width: 443px;
            height: 154px;
        }
        #u6349 .text {
            position: relative;
            align-self: flex-start;
            padding: 12px 20px 12px 20px;
            box-sizing: border-box;
            width: 100%;
        }
        #u6349_text {
            border-width: 0px;
            white-space: nowrap;
            text-transform: none;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        {{--<div class="row">
            <div id="u6347" class="ax_default">
                <div ID="u6348" class="ax_default">
                    <img id="u6348_img" src="{{ $road_image }}" alt="">
                    <div id="u6348_text" class="text" style="display: none; visibility: hidden;">
                        <p></p>
                    </div>
                </div>
                <div id="u6349" class="ax_default label" style="cursor: pointer;">
                    <img id="u6349_img" src="{{ $background }}" tabindex="0">
                    <div id="u6349_text" class="text">
                        <p>
                            <span>{{ __('dictionary.ict_operators') }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <hr>--}}

        <div class="row mb-3">
            <div class="col">
                <h2 class="text-center">{{ __('dictionary.inform_portal') }}</h2>
                <br>
                <h5 class="text-center">{{ __('dictionary.motto1') }}</h5>
                <h5 class="text-center">{{ __('dictionary.motto2') }}</h5>
            </div>
        </div>

        <div class="row">
            <div class="col col-sm-6">
                <div class="card bg-dark text-white">
                    <img src="{{ $road_image }}" class="card-img" alt="..." style="opacity: 0.67; height: 390px;">
                    <div class="card-img-overlay">
                        <br><br><br><br><br><br><br>
                        <a  class="btn btn-outline-light" href="{{ route('login') }}">
                            <h3 class="card-title text-center">{{ __('dictionary.infrastructure_owners') }}</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col col-sm-6">
                <div class="card bg-dark text-white">
                    <img src="{{ $ict_image }}" class="card-img" alt="..." style="opacity: 0.67; height: 390px;">
                    <div class="card-img-overlay">
                        <br><br><br><br><br><br><br>
                        <a  class="btn btn-outline-light" href="{{ route('login') }}">
                            <h3 class="card-title text-center">{{ __('dictionary.ict_operators') }}</h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection