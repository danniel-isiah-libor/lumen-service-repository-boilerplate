<?php

namespace App\Sources\Support\BaseContracts;

interface UpdateInterface
{
    /**
     * PUT request to the API update endpoint.
     * 
     * @param int $id
     * @param array $params
     * @return mixed
     */
    public function update(int $id, array $params = []);
}
