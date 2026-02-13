<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;
    
    public function view(AuthUser $authUser, Location $location): bool
    {
        return $authUser->can('View:Location');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Location');
    }

    public function update(AuthUser $authUser, Location $location): bool
    {
        return $authUser->can('Update:Location');
    }

    public function delete(AuthUser $authUser, Location $location): bool
    {
        return $authUser->can('Delete:Location');
    }

}