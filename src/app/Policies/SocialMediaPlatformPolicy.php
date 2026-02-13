<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SocialMediaPlatform;
use Illuminate\Auth\Access\HandlesAuthorization;

class SocialMediaPlatformPolicy
{
    use HandlesAuthorization;
    
    public function view(AuthUser $authUser, SocialMediaPlatform $socialMediaPlatform): bool
    {
        return $authUser->can('View:SocialMediaPlatform');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SocialMediaPlatform');
    }

    public function update(AuthUser $authUser, SocialMediaPlatform $socialMediaPlatform): bool
    {
        return $authUser->can('Update:SocialMediaPlatform');
    }

    public function delete(AuthUser $authUser, SocialMediaPlatform $socialMediaPlatform): bool
    {
        return $authUser->can('Delete:SocialMediaPlatform');
    }

}