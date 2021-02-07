<select v-model="statusSelect" @change="updateStatus($route)"
        class="form-select @error('status') is-invalid @enderror">
    <option v-for="status in statuses" :value="status.id">
        @{{ status.name }}
    </option>
</select>
