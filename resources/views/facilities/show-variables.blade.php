{{ __('account.economic_variables') }}
@foreach($facilities as $facility)
    <h5>{{ $facility->user->full_name }}</h5>
    @foreach($facility->variablesGroups as $group)
        <p>{{ $group->title }}</p>
    <table class="table table-sm table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ __('variable.variable') }}</th>
            <th>{{ __('variable.unit') }}</th>
            <th>{{ __('variable.value') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($group->variables as $variable)
        <tr>
            <td width="5%">{{ $loop->iteration }}</td>
            <td width="70%">{{ $variable->description }}</td>
            <td width="15%">{{ $variable->unit }}</td>
            <td width="10%">{{ $variable->value }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endforeach
    <hr>
@endforeach