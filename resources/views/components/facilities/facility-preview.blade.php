<div class="card">
    <div class="card-header">
        <b>{{ $facility->title }}</b>
    </div>
    <div class="card-body">
        <h6 class="card-text">{{ $facility->preview }}</h6>
        <p><b>{{ __('facility.type') }}: </b> {{ $facility->type->name }}</p>
        <p><b>{{ __('facility.location') }}: </b> {{ $facility->location }}</p>
        <p><b>{{ __('facility.owner') }}: </b> {{ $facility->user->full_name }}</p>
        <hr>

        @if($showCompatibilityLevel)
            @can('use-advanced-search')
                <p><b>{{ __('facility.c_level') }}: </b> {{ $facility->compatibility_level }}</p>
            @endcan
        @endif

        {{ $slot }}
    </div>
</div>