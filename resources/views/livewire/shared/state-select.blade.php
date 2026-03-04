<div>
    <select
        wire:model="stateId"
        id="registered_state_id"
        class="select select-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800"
        required
    >
        <option value="">Select state</option>
        @foreach ($states as $state)
            <option value="{{ $state->id }}">
                {{ $state->name }}
            </option>
        @endforeach
    </select>
</div>

