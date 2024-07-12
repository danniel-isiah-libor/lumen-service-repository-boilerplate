<?php

namespace App\Sources\AuditTrail\Contracts;

use App\Sources\Support\BaseContracts\{
    StoreInterface as Store,
    DeleteInterface as Delete,
    UpdateInterface as Update,
};

interface ActivityLogSourceInterface extends Store, Delete, Update
{
    /**
     * Create activity log
     *
     * @param array $request
     * @return mixed
     */
    public function log(array $request);
}
