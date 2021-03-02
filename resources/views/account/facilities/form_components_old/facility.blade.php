<div class="mb-3 row">
    <label for="title" class="col-sm-2 col-form-label">{{ __('facility.title') }}</label>
    <div class="col-sm-10">
        <input type="text" name="title"
               class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title') ?? $facility->title }}">

        @error('title')
        <x-invalid-feedback :message="$message"/>
        @enderror
    </div>
</div>

<div class="mb-3 row">
    <label for="identificator" class="col-sm-2 col-form-label">{{ __('facility.facility_id') }}</label>
    <div class="col-sm-10">
        <div name="identificator">
            {{ $facility->identificator }}
        </div>
    </div>
</div>

<div class="mb-3 row">
    <label for="visibility" class="col-sm-2 col-form-label">{{ __('facility.visibility') }}</label>
    <div class="col-sm-10">
        <select class="form-select @error('visibility') is-invalid @enderror" id="visibility" name="visibility">
            <option hidden>{{ __('facility.select_visibility') }}</option>
            @foreach($visibilities as $visibility)
                <option value="{{ $visibility->id }}"
                    {{ $facility->visibility->id === $visibility->id ? 'selected' : '' }}>
                    {{ $visibility->name }}
                </option>
            @endforeach
        </select>

        @error('visibility')
            <x-invalid-feedback :message="$message"/>
        @enderror
    </div>
</div>

<div class="mb-3 row">
    <label for="type" class="col-sm-2 col-form-label">{{ __('facility.type') }}</label>
    <div class="col-sm-10">
        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" @change="getType">
            <option hidden>{{ __('facility.select_type') }}</option>
            @foreach($types as $type)
                <option value="{{ $type->id }}"
                    {{ $facility->type->id === $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
            @endforeach
        </select>

        @error('type')
            <x-invalid-feedback :message="$message"/>
        @enderror
    </div>
</div>

<div class="mb-3 row">
    <label for="location" class="col-sm-2 col-form-label">{{ __('facility.location') }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control @error('location') is-invalid @enderror"
               id="location" name="location" value="{{ old('location') ?? $facility->location }}">

        @error('location')
            <x-invalid-feedback :message="$message"/>
        @enderror
    </div>
</div>

<div class="mb-3 row">
    <label for="description" class="col-sm-2 col-form-label">{{ __('facility.description') }}</label>
    <div class="col-sm-10">
        <textarea name="description" class="form-control @error('description')
            is-invalid @enderror">{{ old('description') ?? $facility->description }}</textarea>

        @error('description')
            <x-invalid-feedback :message="$message"/>
        @enderror
    </div>
</div>

<div class="mb-3 row">
    <label for="attachments" class="col-sm-2 col-form-label">{{ __('facility.attachments') }}</label>
    <div class="col-sm-10">
        <input class="form-control" type="file" id="attachments" name="attachments[]" multiple>
    </div>
</div>
