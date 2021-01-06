<div>
    <div class="btn-group me-2" role="group">
        <form action="{{ route($route, $article) }}" method="POST">
        @method('DELETE')
        @csrf
            <button type="submit" class="btn btn-sm btn-danger"
                    style="float: right">{{ __('knowledgebase.delete') }}</button>
        </form>
    </div>
</div>