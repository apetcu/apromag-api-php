<?php

namespace App\Providers;

use App\Http\Models\PaginatedResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class JsonApiPaginateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                base_path('/config/pagination.php') => config_path('pagination.php'),
            ], 'config');
        }

        $this->registerMacro();
    }

    public function register()
    {
        $this->mergeConfigFrom(base_path('/config/pagination.php'), 'pagination');
    }

    protected function registerMacro()
    {
        Builder::macro(config('pagination.method_name'), function ($callback = null, int $maxResults = null, int $defaultSize = null ) {
            $maxResults = $maxResults ?? config('pagination.max_results');
            $defaultSize = $defaultSize ?? config('pagination.default_size');
            $numberParameter = config('pagination.number_parameter');
            $sizeParameter = config('pagination.size_parameter');
            $paginationParameter = config('pagination.pagination_parameter');

            $size = (int) request()->input($sizeParameter, $defaultSize);
            $orderBy = request()->input('orderBy', 'id');
            $orderDir = request()->input('orderDir', 'asc');
            $pageNo = request()->input($numberParameter, 1);
            $size = $size > $maxResults ? $maxResults : $size;
            
            logger(request()->input($sizeParameter));

            $paginator = $this
                ->orderBy($orderBy ? $orderBy : 'id', $orderDir)
                ->paginate($size, ['*'], $paginationParameter.'.'.$numberParameter, $pageNo)
                ->setPageName($paginationParameter.'['.$numberParameter.']')
                ->appends(Arr::except(request()->input(), $paginationParameter.'.'.$numberParameter));

            if (! is_null(config('pagination.base_url'))) {
                $paginator->setPath(config('pagination.base_url'));
            }

            if($callback){
                $paginator->getCollection()->transform(function ($value) use ($callback) {
                    return $callback($value);
                });
            }
            return new PaginatedResponse($paginator);
        });
    }
}