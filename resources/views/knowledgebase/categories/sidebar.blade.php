<ul class="list-group list-group-flush">
    @foreach($categories as $category)
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <a style="text-decoration: none; color: black" href="{{ route('articles.category', $category->id) }}">
                    {{ $category->name }}
                </a>
                <span class="badge bg-primary rounded-pill">
                    {{ $category->articles->count() }}
                </span>
            </div>
        </li>
    @endforeach
</ul>
