<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item text-center">
            <a href="{{ route('admin.articles.index') }}" class="btn btn-link">{{ __('admin.knowledge_base') }}</a>
        </li>
        <li class="list-group-item text-center">
            <a href="{{ route('admin.facilities.index') }}" class="btn btn-link">{{ __('admin.facilities') }}</a>
        </li>
        <li class="list-group-item text-center">
            <a href="{{ route('admin.facilities.compatibility_params.index') }}" class="btn btn-link">{{ __('admin.compatibility_params') }}</a>
        </li>
        <li class="list-group-item text-center">
            <a href="{{ route('admin.facilities.variables.index') }}" class="btn btn-link">{{ __('admin.economic_efficient_vars') }}</a>
        </li>
        <li class="list-group-item text-center">
            <a href="{{ route('admin.users.index') }}" class="btn btn-link">{{ __('admin.users') }}</a>
        </li>
    </ul>
</div>
