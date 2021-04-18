@section('styles')
    <link href="{{ asset('css/href.css') }}" rel="stylesheet">
@endsection

<div id="sidebar">
    <ul class="list-group list-group-flush">
        @foreach($categories as $category)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <em>
                        <a href="{{ route('articles.category', $category->id) }}">
                            {{ $category->name }}
                        </a>
                    </em>
                    <span class="badge bg-primary rounded-pill">
                        {{ $category->articles->count() }}
                    </span>

                    @foreach($category->children as $child)
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <a href="{{ route('articles.category', $child->id) }}">
                                        {{ $child->name }}
                                    </a>
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $child->articles->count() }}
                                    </span>
                                </div>
                            </li>
                        </ul>
                    @endforeach
                </div>
            </li>
        @endforeach
    </ul>
</div>
