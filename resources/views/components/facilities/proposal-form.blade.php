<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ __('proposal.send_proposal') }}</h5>
        <form method="post" action="{{ route('proposal.send', [$senderFacility, $receiverFacility]) }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="details" class="form-label">{{ __('proposal.details') }}</label>
                <textarea name="description" id="details" class="form-control form-control-sm @error('description') is-invalid @enderror"></textarea>
                @error('description')
                <x-invalid-feedback :message="$message"/>
                @enderror
            </div>
            <div class="mb-3">
                <label for="attachments" class="form-label">{{ __('proposal.attachments') }}</label>
                <input type="file" class="form-control form-control-sm" name="attachments[]" id="attachments" multiple>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">{{ __('proposal.send_proposal') }}</button>
        </form>
    </div>
</div>
