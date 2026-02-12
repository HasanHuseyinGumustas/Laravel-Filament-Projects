<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\EventCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventCategoryPolicy
{
    use HandlesAuthorization;
    
    public function view(AuthUser $authUser, EventCategory $eventCategory): bool
    {
        return $authUser->can('View:EventCategory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:EventCategory');
    }

    public function update(AuthUser $authUser, EventCategory $eventCategory): bool
    {
        return $authUser->can('Update:EventCategory');
    }

    public function delete(AuthUser $authUser, EventCategory $eventCategory): bool
    {
        return $authUser->can('Delete:EventCategory');
    }

}