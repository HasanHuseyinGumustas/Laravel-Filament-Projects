<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ScrappedEvent;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScrappedEventPolicy
{
    use HandlesAuthorization;
    
    public function view(AuthUser $authUser, ScrappedEvent $scrappedEvent): bool
    {
        return $authUser->can('View:ScrappedEvent');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ScrappedEvent');
    }

    public function update(AuthUser $authUser, ScrappedEvent $scrappedEvent): bool
    {
        return $authUser->can('Update:ScrappedEvent');
    }

    public function delete(AuthUser $authUser, ScrappedEvent $scrappedEvent): bool
    {
        return $authUser->can('Delete:ScrappedEvent');
    }

}