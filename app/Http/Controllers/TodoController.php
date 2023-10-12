<?php

namespace App\Http\Controllers;

use App\Enums\Todo\StatusEnum;
use App\Http\Requests\TodoStoreRequest;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $todos = Todo::whereBelongsTo(auth()->user())
            ->whereStatus(StatusEnum::PENDING->value)
            ->when($request->has('search'), function (Builder $query) {
                $strings = explode(' ', request()->input('search'));

                foreach ($strings as $key => $string) {
                    $query->where(function (Builder $query) use ($string) {
                        $query->orWhere('name', 'LIKE', "%{$string}%")
                            ->orWhere('description', 'LIKE', "%{$string}%");
                    });
                }

            })
            ->latest()
            ->simplePaginate(15);

        return view('todos.index')
            ->with('todos', $todos)
            ->with('request', $request)
            ->fragmentIf($request->hasHeader('HX-Request'), 'todos-list');
    }

    public function store(TodoStoreRequest $todoRequest)
    {
        auth()->user()->todos()->create($todoRequest->validated());

        return view('todos.form');
    }

    public function changeStatus(Todo $todo, StatusEnum $statusEnum)
    {
        if (!$todo->status->isPending()) {
            throw new \Exception(__('Todo is not pending'), 403);
        }

        throw new \Exception(__('Todo is not pending'), 403);
        $todo->status = $statusEnum->value;
        $todo->saveOrFail();
    }
}
