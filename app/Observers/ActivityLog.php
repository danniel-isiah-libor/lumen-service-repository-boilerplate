<?php

namespace App\Observers;

use Illuminate\Support\Arr;

use App\Helper\Contracts\AuthInterface as Auth;
use App\Sources\AuditTrail\Contracts\ActivityLogSourceInterface as ActivityLogSource;

abstract class ActivityLog
{
    /**
     * @var \App\Helper\Contracts\AuthInterface
     */
    protected $auth;

    /**
     * @var \App\Sources\AuditTrail\Contracts\ActivityLogSourceInterface
     */
    protected $activityLogSource;

    /**
     * Create the class instance.
     * 
     * @param App\Helper\Contracts\AuthInterface
     * @param App\Sources\AuditTrail\Contracts\ActivityLogSourceInterface
     */
    public function __construct(
        Auth $auth,
        ActivityLogSource $activityLogSource
    ) {
        $this->activityLogSource = $activityLogSource;
        $this->auth = $auth;
    }

    /**
     * Perform audit trail logging.
     * 
     * @param array $data
     * @return mixed
     */
    public function log($data)
    {
        $payload = [
            'merchant_uuid' => $this->auth->merchantUuid(),
            'user_uuid' => $this->auth->userUuid(),
            'user_type' => $this->auth->userType(),
            'old_data' => Arr::get($data, 'old_data'),
            'new_data' => Arr::get($data, 'new_data'),
            'service' => Arr::get($data, 'service'),
            'activity_type' => Arr::get($data, 'activity_type')
        ];

        return $this->activityLogSource->log($payload);
    }
}
