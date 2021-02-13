<div>
    <form action="{{ route($route, $proposal) }}" method="post">
        @csrf
        <div class="btn-group me-2" role="group" aria-label="First group">
            <button type="submit" class="btn btn-{{ $class }} btn-sm">{{ __($caption) }}</button>
        </div>
    </form>
</div>