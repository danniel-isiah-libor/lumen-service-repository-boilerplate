<?php

namespace App\Sources\AuditTrail;

use Illuminate\Support\Arr;
use Rush\Helper\MicroService;

use App\Sources\Source;
use App\Sources\AuditTrail\Contracts\ActivityLogSourceInterface;
use App\Sources\Support\BaseContracts\HttpRequestInterface as HttpRequest;

class ActivityLogSource extends Source implements ActivityLogSourceInterface
{
    /**
     * @var \App\Sources\Support\BaseContracts\HttpRequestInterface
     */
    protected $httpRequest;

    /**
     * Create the source instance and declare the route endpoint.
     * 
     * @param Rush\Helper\MicroService
     * @param App\Sources\Support\BaseContracts\HttpRequestInterface
     */
    public function __construct(MicroService $microService, HttpRequest $httpRequest)
    {
        $this->route = sprintf('%s/v1/service/admin/logs', env('AUDIT_TRAIL_SERVICE_URL'));

        $this->token = $microService->generateToken(env('SERVICE_NAME'), env('SERVICE_KEY'));

        $this->httpRequest = $httpRequest;
    }

    /**
     * Create activity log
     *
     * @param array $request
     * @return mixed
     */
    public function log($request)
    {
        $url = sprintf('%s/save', $this->route);

        Arr::set($headers, 'Accept', 'application/json');

        Arr::set($headers, 'Authorization', $this->token);

        return $this->httpRequest->post($url, $request, $headers);
    }
}
