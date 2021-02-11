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
                <table class="table">
                    <tbody>
                        @foreach($project->comments as $comment)
                            <tr>
                                <td>
                                    <img src="{{ $comment->user->photo }}" height="40"> {{ $comment->user->full_name }}
                                </td>
                                <td>{{ $comment->content }}</td>
                                <td>{{ $comment->date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                    {{ old('content') ?? (isset($comment) ? $comment->content : '') }}
                </textarea>

                @error('content')
                    <x-invalid-feedback :message="$message"/>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('account.add_comment') }}</button>
        </form>
    </div>
</div>

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    CKEDITOR.replace('content');
</script>
