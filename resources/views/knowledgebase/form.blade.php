@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('knowledgebase.NewArticle') }}</div>

                    <div class="card-body">
                        <form action="{{ route('articles.store') }}" method="post">
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('knowledgebase.Title') }}</label>
                                <input type="text" name="title" class="form-control" id="title">
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">{{ __('knowledgebase.Content') }}</label>
                                <textarea name="content" id="content" cols="30" rows="10"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript">
            CKEDITOR.replace('content');
        </script>
    </div>
@endsection