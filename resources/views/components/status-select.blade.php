<div id="status-data" data-route="{{ json_encode($route) }}">
    <select name="status" @change="updateStatus"
            class="form-select @error('status') is-invalid @enderror">
        @foreach($statuses as $status)
            <option value="{{ $status->id }}" {{ $proposal->status->id === $status->id ? 'selected' : '' }}>
                {{ $status->name }}
            </option>
        @endforeach
    </select>
</div>
