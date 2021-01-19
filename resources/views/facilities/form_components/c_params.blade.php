@foreach($compatibility_params as $group)
    <h5 class="text-center">{{ $group->name }}</h5>
    @foreach($group->params as $param)
        <p>{{ $param->name }}</p>
    @endforeach
@endforeach