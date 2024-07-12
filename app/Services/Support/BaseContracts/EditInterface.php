<?php

namespace App\Services\Support\BaseContracts;

interface EditInterface
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param int|string $id
     * @param bool $findOrFail
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function edit($id, bool $findOrFail = true);
}
