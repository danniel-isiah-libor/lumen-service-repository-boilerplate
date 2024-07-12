<?php

namespace App\Observers;

use App\Models\User;

class UserObserver extends ActivityLog
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $model
     * @return void
     */
    public function created(User $model)
    {
        $this->log([
            'old_data' => [],
            'new_data' => $model,
            'service' => 'Service',
            'activity_type' => 'Create User'
        ]);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $model
     * @return void
     */
    public function updated(User $model)
    {
        $this->log([
            'old_data' => $model->getOriginal(),
            'new_data' => $model,
            'service' => 'Service',
            'activity_type' => 'Update User'
        ]);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $model
     * @return void
     */
    public function deleted(User $model)
    {
        $this->log([
            'old_data' => $model->getAttributes(),
            'new_data' => ["data" => "deleted"],
            'service' => 'Service',
            'activity_type' => 'Delete User'
        ]);
    }
}
