<form action="{{ route($route, $article) }}" method="POST">
@method('DELETE')
@csrf
    <button type="submit" class="btn btn-sm btn-danger" style="float: right">{{ __('knowledgebase.delete') }}</button>
</form>
