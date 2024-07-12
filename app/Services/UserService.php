<?php

namespace App\Services;

use App\Actions\User\Search;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;

class UserService extends Service implements UserServiceInterface
{
    /**
     * @var \App\Actions\User\Search
     */
    protected $searchAction;

    /**
     * Create the service instance and inject its repository.
     *
     * @param App\Repositories\Contracts\UserRepositoryInterface
     * @param App\Actions\User\Search
     */
    public function __construct(UserRepositoryInterface $repository, Search $searchAction)
    {
        $this->repository = $repository;
        $this->searchAction = $searchAction;
    }

    /**
     * Search for specific resources in the database.
     *
     * @param  array  $request
     * @return \Illuminate\Http\Response
     */
    public function search(array $request)
    {
        return $this->searchAction->execute($request);
    }
}
