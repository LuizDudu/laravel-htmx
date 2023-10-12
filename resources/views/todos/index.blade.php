<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @include('todos.form')
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-10">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <div class="pb-5">
                    <x-input-label>{{ __('Search todo') }}</x-input-label>
                    <x-text-input type="search" name="search" hx-get="{{ route('todos.index') }}"
                      hx-trigger="keyup changed delay:500ms, search"
                      hx-target="#todos-list"
                      hx-swap="outerHTML"
                      hx-indicator="#laba"
                    />
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Name') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Description') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Status') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                        </thead>

                        @fragment('todos-list')
                            <tbody id="todos-list"
                                   hx-get="{{ route('todos.index') }}"
                                   hx-swap="outerHTML"
                                   hx-trigger="submit from:#todos-form">
                            @forelse($todos as $todo)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                    @if($loop->last && strpos($todos->nextPageUrl(), 'page'))
                                        hx-get="{{ $todos->nextPageUrl() }}"
                                    hx-swap="afterend"
                                    hx-select="tr"
                                    hx-trigger="revealed"
                                        @endif>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $todo->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $todo->description }}
                                    </td>
                                    <td @class([
                                        'px-6 py-4',
                                        'text-yellow-500' => $todo->status->isPending(),
                                        'text-red-500' => $todo->status->isCanceled(),
                                        'text-green-500' => $todo->status->isCompleted(),
                                    ])>
                                        {{ __('enums.todos.status.' . $todo->status->name) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($todo->status->isPending())
                                            <div class="flex gap-5 text-center items-center" hx-confirm="{{ __('Are you sure?') }}">
                                                <x-secondary-button
                                                        class="action-buttons flex gap-2 outline-green-500 outline outline-1 hover:bg-green-800 dark:hover:bg-green-800"
                                                        hx-patch="{{ route('todos.change-status', ['todo' => $todo->id, 'statusEnum' => \App\Enums\Todo\StatusEnum::COMPLETED->value]) }}"
                                                        hx-target="closest tr"
                                                        hx-swap="outerHTML"
                                                        hx-disabled-elt=".action-buttons"
                                                        hx-indicator="#complete-spin-{{ $todo->id }}"
                                                >
                                                    <x-ui.loading-svg id="complete-spin-{{ $todo->id }}" class="w-auto h-4" />
                                                    Complete
                                                </x-secondary-button>

                                                <x-secondary-button
                                                    class="action-buttons flex gap-2 outline-red-500 outline outline-1 hover:bg-red-800 dark:hover:bg-red-800"
                                                    hx-patch="{{ route('todos.change-status', ['todo' => $todo->id, 'statusEnum' => \App\Enums\Todo\StatusEnum::CANCELED->value]) }}"
                                                    hx-target="closest tr"
                                                    hx-swap="outerHTML"
                                                    hx-disabled-elt=".action-buttons"
                                                    hx-indicator="#cancel-spin-{{ $todo->id }}"
                                                >
                                                    <x-ui.loading-svg id="cancel-spin-{{ $todo->id }}" class="w-auto h-4" />
                                                    Cancel
                                                </x-secondary-button>
                                                @error('todo-is-not-pending') <span class="text-red-600"> {{ $message }}</span> @enderror
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-gray-100 pt-8 text-xl text-center">
                                        {{ __('Without') . ' ' . __('Todos') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        @endfragment
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>