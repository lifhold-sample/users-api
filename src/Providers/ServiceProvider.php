<?php

declare(strict_types=1);

namespace Lifhold\Users\Api\Providers;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
    }

    public function boot()
    {
        JsonResource::withoutWrapping();
    }
}
