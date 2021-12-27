<?php

namespace NovaAdDirector\Policies\Nova;

use Illuminate\Auth\Access\HandlesAuthorization;

class AdConfigurationPolicy
{
    use HandlesAuthorization;

    public function viewAny($user)
    {
        return true;
    }

    public function view($user, $model)
    {
        return true;
    }

    public function create($user)
    {
        return config('nova-ad-director.creatable');
    }

    public function update($user, $model)
    {
        return true;
    }

    public function delete($user)
    {
        return config('nova-ad-director.creatable');
    }

    public function forceDelete($user)
    {
        return config('nova-ad-director.creatable');
    }

    public function restore($user)
    {
        return config('nova-ad-director.creatable');
    }
}
