<?php

namespace App\Policies;

use App\Models\Autobulance;
use App\Models\Client;
use Illuminate\Auth\Access\Response;

class AutobulancePolicy
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
    public function view(Client $client, Autobulance $autobulance): bool
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
    public function update(Client $client, Autobulance $autobulance): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Client $client, Autobulance $autobulance): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Client $client, Autobulance $autobulance): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Client $client, Autobulance $autobulance): bool
    {
        //
    }
}
