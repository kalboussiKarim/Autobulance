<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Task;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Client $client): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Client $client, Task $task): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Client $client): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Client $client, Task $task): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Client $client, Task $task): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Client $client, Task $task): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Client $client, Task $task): bool
    {
        //
    }
}
