<div class="card mb-3">
    <div class="card-header">
        {{ __('account.comments') }}
    </div>

    <div class="card-body">
        @if (session()->has('message'))
            <div class="alert alert-info d-flex align-items-center justify-content-center mb-2">
                {{ session('message') }}
            </div>
        @endif

        <div class="card-body">
            @forelse($project->comments as $comment)
                <div class="row">
                    <div class="col-1">
                        <img src="{{ $comment->user->photo }}" height="40"> {{ $comment->user->full_name }}
                    </div>
                    <div class="col-9">
                        {!! $comment->content !!}
                    </div>
                    <div class="col" style="text-align:right">
                        {{ $comment->date }}
                    </div>
                </div>

                @commentFilesNotDeleted($comment)
                    <div class="my-4">
                        <label class="form-label">{{ __('knowledgebase.Files') }}</label>

                        <form method="POST">
                            @method('DELETE')
                            @csrf
                            @foreach($comment->files as $file)
                                <div class="mb-1">
                                    <a href="{{ $file->link }}" target="_blank">{{ $file->name }}</a>
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            formaction="{{ route('account.projects.delete_file',
                                                                    [$project, $comment, $file]) }}">
                                        Удалить файл
                                    </button>
                                </div>
                            @endforeach
                        </form>
                    </div>
                @endcommentFilesNotDeleted
                <hr>
            @empty
                <h6>{{ __('account.no_comments') }}</h6>
            @endforelse
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('account.projects.add_comment', $project) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <textarea name="content" id="content" cols="30" rows="10"
                          class="@error('content') is-invalid @enderror">
                    {{ old('content') ?? '' }}
                </textarea>

                @error('content')
                    <x-invalid-feedback :message="$message"/>
                @enderror
            </div>

            <div class="mb-3">
                <input type="file" name="files[]" class="form-control @error('files') is-invalid @enderror" multiple>

                @error('file')
                    <x-invalid-feedback :message="$message"/>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary">{{ __('account.add_comment') }}</button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    CKEDITOR.replace('content');
</script>
