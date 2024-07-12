<?php

namespace App\Sources\Support\Traits;

use Illuminate\Support\Arr;

use App\Sources\Support\BaseContracts\HttpRequestInterface as HttpRequest;

trait ApiResource
{
    /**
     * POST request to the API store endpoint.
     * 
     * @param array $request
     * @return mixed
     */
    public function store(array $request)
    {
        Arr::set($headers, 'Accept', 'application/json');

        if ($this->token) Arr::set($headers, 'Authorization', sprintf('Bearer %s', $this->token));

        return HttpRequest::post($this->route, $request, $headers);
    }

    /**
     * PUT request to the API update endpoint.
     * 
     * @param int $id
     * @param array $params
     * @return mixed
     */
    public function update(int $id, array $params = [])
    {
        $route = sprintf('%s/%d', $this->route, $id);

        Arr::set($headers, 'Accept', 'application/json');

        if ($this->token) Arr::set($headers, 'Authorization', sprintf('Bearer %s', $this->token));

        return HttpRequest::put($route, $params, $headers);
    }

    /**
     * DELETE request to the API auth endpoint.
     *
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        $route = sprintf('%s/%d', $this->route, $id);

        Arr::set($headers, 'Accept', 'application/json');

        if ($this->token) Arr::set($headers, 'Authorization', sprintf('Bearer %s', $this->token));

        return HttpRequest::delete($route, [], $headers);
    }
}
