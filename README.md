# **Service-Action-Repository Pattern**

> *Snippets can be downloaded [here](Rush-Lumen-Services.code-snippets)*

The goal of this is to isolate each operation to their designated classes. This is to help for faster development and better maintainability.

- Controller - focuses on handling the response, exception, middleware, and validation.
- Service / Action - focuses on fulfilling business logics and needs.
- Repository - focuses on fulfilling application logics and query operations.

Every function should be defined as well in the interface class.

> ### **Controller Class Usage**

Define the functions you need inside the controller.

*Note: you may use the snippet `rush-service-controller`*

```php
<?php

namespace App\Http\Controllers;

use App\Services\Contracts\UserServiceInterface;
use App\Http\Requests\User\{
    StoreRequest
};

class UserController extends Controller
{
    /**
     * The service instance.
     *
     * @var \App\Services\Contracts\UserServiceInterface
     */
    protected $service;

    /**
     * Create the controller instance and resolve its service.
     * 
     * @param \App\Services\Contracts\UserServiceInterface $service
     */
    public function __construct(UserServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\User\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $validatedRequest = $request->validated();

        return $this->response(
            'Store a newly created resource in storage.',
            function () use ($validatedRequest) {
                return $this->service->store($validatedRequest);
            }
        );
    }
}
```

To use the `$this->response()` function to format and handle the response, you have to include the function inside `app\Http\Controllers\Controller.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{DB, Log};
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Handle service response.
     * 
     * @param String $msg
     * @param function $fn
     * @return \Illuminate\Http\Response
     */
    protected function response($msg, $fn)
    {
        DB::beginTransaction();

        try {
            $data = $fn();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => $msg,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Exception : ", [$e->getMessage()]);

            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }
}
```

If you wish to have access to authenticated user’s data accross all your instance, you can use the `UserMiddleware.php`. You may use `app\Helper\Auth.php` to access it manually.

Example controller usage:

```php
<?php

namespace App\Http\Controllers;

use App\Services\Contracts\UserServiceInterface;

class UserController extends Controller
{
    /**
     * The service instance.
     *
     * @var \App\Services\Contracts\UserServiceInterface
     */
    protected $service;

    /**
     * Create the controller instance and resolve its service.
     * 
     * @param \App\Services\Contracts\UserServiceInterface $service
     */
    public function __construct(UserServiceInterface $service)
    {
        $this->middleware('user');

        $this->service = $service;
    }
}
```

> ### Form Request Validation Usage

The usage is somewhat similar to Laravel. For more information, Kindly refer in this link: [https://laravel.com/docs/10.x/validation#creating-form-requests](https://laravel.com/docs/10.x/validation#creating-form-requests)

*Note: you may use the snippet `rush-service-form-request`*

```php
<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * 
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string'
            ],
            'email' => [
                'required',
                'email'
            ]
        ];
    }
}
```

> ### Service Class Usage

This is the intended structure for service class. Contract folder contains all the service interface classes. Under the Support folder, BaseContracts contains all the reusable interfaces that can be extends to user defined interfaces. Inside Services folder, contains all user defined services. Within the service you may use a Resource class when needed.

*Note: don’t forget to define service classes inside `AppServiceProvider.php`*

Example service class:

*Note: you may use the snippet `rush-service-class`*

```php
<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;

class UserService extends Service implements UserServiceInterface
{
    /**
     * Create the service instance and inject its repository.
     *
     * @param App\Repositories\Contracts\UserRepositoryInterface
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
```

Example service interface clas:

*Note: you may use the snippet `rush-service-interface`*

```php
<?php

namespace App\Services\Contracts;

use App\Services\Support\BaseContracts\StoreInterface as Store;

interface UserServiceInterface extends Store
{
    /**
     * Here you insert custom functions.
     */
}
```

In most cases, the Service class can be a bit clottered. Too many functions and long lines of codes are inevitable. Action class can be handy, isolating only its own function to a separate Action class.

Example service class:

*Note: you may use the snippet `rush-service-class`*

```php
<?php

namespace App\Services;

use App\Actions\User\Store;
use App\Services\Contracts\UserServiceInterface;

class UserService extends Service implements UserServiceInterface
{
    /**
     * @var \App\Actions\User\Store
     */
    protected $storeAction;

    /**
     * Create the service instance and inject its repository.
     *
     * @param App\Actions\User\Store
     */
    public function __construct(Store $storeAction)
    {
        $this->storeAction = $storeAction;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $request)
    {
        return $this->storeAction->execute($request);
    }
}
```

Example action class:

*Note: you may use the snippet `rush-service-action`*

```php
<?php

namespace App\Actions\User;

use App\Repositories\Contracts\UserRepositoryInterface as UserRepository;

class Store
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
     * @return mixed
     */
    public function execute()
    {
        /**
         * Put your big chunk of codes here for store() function.
         * 
         * Return a response.
         */
    }
}
```

> ### Repository Class Usage

If you wish to access the model via repository, you can call the function model().

*Note: don’t forget to define repository classes inside `RepositoryServiceProvider.php`*

Example repository class:

*Note: you may use the snippet `rush-service-repository`*

```php
<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * Create the repository instance.
     *
     * @param \App\Models\User
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
```

Example repository interface class:

*Note: you may use the snippet `rush-service-repository-interface`*

```php
<?php

namespace App\Repositories\Contracts;

use App\Repositories\Support\BaseContracts\CreateInterface as Create;

interface UserRepositoryInterface extends Create
{
    /**
     * Here you insert custom functions.
     */
}
```

To modify and add custom reusable queries, you may insert it inside `ModelResource.php` and define its interface class.

```php
<?php

namespace App\Repositories\Support;

trait ModelResource
{
    /**
     * Store a newly created resource in storage.
     *
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $request = [])
    {
        return (count($request)) ? $this->model->create($request) : $this->model->create();
    }
}
```

> ### Service-to-Service Usage

With the help of this pattern, it would be easier to pin point bugs when troubleshooting.

Example source class:

*Note: you may use the snippet `rush-service-source`*

```php
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
```

Example source interface class:

*Note: you may use the snippet `rush-service-source-interface`*

```php
<?php

namespace App\Sources\AuditTrail\Contracts;

use App\Sources\Support\BaseContracts\{
    StoreInterface as Store,
    DeleteInterface as Delete,
    UpdateInterface as Update,
};

interface ActivityLogSourceInterface extends Store, Delete, Update
{
    /**
     * Create activity log
     *
     * @param array $request
     * @return mixed
     */
    public function log(array $request);
}
```

> ### Audit Log Usage

One way to set this up is via Observer class, it will log each model events.

Example observer class:

*Note: you may use the snippet `rush-service-observer`*

```php
<?php

namespace App\Observers;

use App\Models\User;

class UserObserver extends ActivityLog
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $model
     * @return void
     */
    public function created(User $model)
    {
        $this->log([
            'old_data' => [],
            'new_data' => $model,
            'service' => 'Service',
            'activity_type' => 'Create User'
        ]);
    }
}
```

