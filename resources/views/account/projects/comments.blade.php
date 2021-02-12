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
                    <div class="col-10">
                        {{ $comment->content }}
                    </div>
                    <div class="col">
                        {{ $comment->date }}
                    </div>
                </div>
                <hr>
            @empty
                <h6>{{ __('account.no_comments') }}</h6>
            @endforelse
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('account.projects.store', $project) }}" method="POST" enctype="multipart/form-data">
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
                <input type="file" name="file[]" class="form-control @error('file') is-invalid @enderror" multiple>

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
