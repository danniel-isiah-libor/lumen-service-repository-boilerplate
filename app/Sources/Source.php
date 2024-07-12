<?php

namespace App\Sources;

use App\Sources\Support\BaseContracts\SourceInterface;
use App\Sources\Support\Traits\ApiResource;

abstract class Source implements SourceInterface
{
    use ApiResource;

    /**
     * The route for the API.
     * 
     * @var string
     */
    protected $route;

    /**
     * Attach the bearer token in the request header.
     * 
     * @var string
     */
    protected $token;

    /**
     * Create the class instance and inject its dependency.
     * 
     * @param String $route
     */
    public function __construct(string $route)
    {
        $this->route = $route;
    }

    /**
     * Get the route for the API endpoint.
     * 
     * @return string
     */
    public function route()
    {
        return $this->route;
    }

    /**
     * Requires the bearer token in the request header.
     * 
     * @return string
     */
    public function token()
    {
        return $this->token;
    }
}
