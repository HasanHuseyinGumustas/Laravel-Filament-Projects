<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SocialMediaUrl;
use Illuminate\Auth\Access\HandlesAuthorization;

class SocialMediaUrlPolicy
{
    use HandlesAuthorization;
    
    public function view(AuthUser $authUser, SocialMediaUrl $socialMediaUrl): bool
    {
        return $authUser->can('View:SocialMediaUrl');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SocialMediaUrl');
    }

    public function update(AuthUser $authUser, SocialMediaUrl $socialMediaUrl): bool
    {
        return $authUser->can('Update:SocialMediaUrl');
    }

    public function delete(AuthUser $authUser, SocialMediaUrl $socialMediaUrl): bool
    {
        return $authUser->can('Delete:SocialMediaUrl');
    }

}