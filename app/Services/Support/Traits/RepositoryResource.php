<?php

namespace App\Services\Support\Traits;

use Illuminate\Support\Arr;

trait RepositoryResource
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\LazyCollection
     */
    public function index()
    {
        return $this->repository->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $request)
    {
        return $this->repository->create($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int|string $id
     * @param bool $findOrFail
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function show($id, bool $findOrFail = true)
    {
        $data = $this->repository->find($id, $findOrFail);

        return isset($data) ? $data : null;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int|string $id
     * @param bool $findOrFail
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function edit($id, bool $findOrFail = true)
    {
        $data = $this->repository->find($id, $findOrFail);

        return isset($data) ? $data : null;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int|string $id
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $request)
    {
        return $this->repository->update($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int|string $id
     * @return int
     */
    public function destroy($id)
    {
        return $this->repository->delete($id);
    }
}
