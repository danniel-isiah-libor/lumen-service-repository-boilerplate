<?php

namespace App\Sources\Support\BaseContracts;

interface DeleteInterface
{
    /**
     * DELETE request to the API delete endpoint.
     * 
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);
}
