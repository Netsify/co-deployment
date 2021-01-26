<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item text-center">
            <a href="{{ route('admin.articles.unchecked') }}" class="btn btn-link">{{ __('knowledgebase.unchecked_articles') }}</a>
        </li>
        <li class="list-group-item text-center">
            <a href="{{ route('admin.articles.published') }}" class="btn btn-link">{{ __('knowledgebase.published_articles') }}</a>
        </li>
        <li class="list-group-item text-center">
            <a href="{{ route('admin.articles.rejected_deleted') }}" class="btn btn-link">{{ __('knowledgebase.rejected_deleted_articles') }}</a>
        </li>
        <li class="list-group-item text-center">
            <a href="{{ route('admin.articles.categories.index') }}" class="btn btn-link">{{ __('knowledgebase.Categories') }}</a>
        </li>
    </ul>
</div>
