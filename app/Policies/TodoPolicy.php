<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Todo $todo): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Todo $todo): bool
    {
    }

    public function delete(User $user, Todo $todo): bool
    {
    }

    public function restore(User $user, Todo $todo): bool
    {
    }

    public function forceDelete(User $user, Todo $todo): bool
    {
    }
}
