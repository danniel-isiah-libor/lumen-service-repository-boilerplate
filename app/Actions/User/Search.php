<?php

namespace App\Actions\User;

use App\Repositories\Contracts\UserRepositoryInterface as UserRepository;

class Search
{
    /**
     * @var App\Repositories\Contracts\UserRepositoryInterface
     */
    protected $repository;

    /**
     * Create the action instance and inject its dependencies.
     *
     * @param App\Repositories\Contracts\UserRepositoryInterface $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the action
     * 
     * @param array
     * @return mixed
     */
    public function execute($request)
    {
        /**
         * Put your big chunk of codes here for store() function.
         * 
         * Return a response.
         */

        return $request;
    }
}
