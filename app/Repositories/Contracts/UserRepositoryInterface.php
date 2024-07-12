<?php

namespace App\Repositories\Contracts;

use App\Repositories\Support\BaseContracts\{
    AllInterface as All,
    CreateInterface as Create,
    FindInterface as Find,
    UpdateInterface as Update,
    DeleteInterface as Delete,
};

interface UserRepositoryInterface extends All, Create, Find, Update, Delete
{
    /**
     * Here you insert custom functions.
     */
}
