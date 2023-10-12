<form
      id="todos-form"
      action="{{ route('todos.store') }}"
      method="POST"
      hx-post="{{ route('todos.store') }}"
      hx-swap="outerHTML"
      hx-target="this">
    @csrf

    <div class="grid gap-6">
        <div>
            <x-input-label>Name</x-input-label>
            <x-text-input name="name" value="{{ old('name') }}" class="w-full"/>
            @error('name') <span class="text-red-600"> {{ $message }}</span> @enderror
        </div>

        <div>
            <x-input-label>Description</x-input-label>
            <x-text-input name="description" value="{{ old('description') }}" class="w-full"/>
            @error('description') <span class="text-red-600"> {{ $message }}</span> @enderror
        </div>
    </div>

    <x-primary-button type="submit" class="mt-4">Submit</x-primary-button>
</form>