<?php

return [

    /*
     * The maximum number of results that will be returned
     * when using the JSON API paginator.
     */
    'max_results' => 200,

    /*
     * The default number of results that will be returned
     * when using the JSON API paginator.
     */
    'default_size' => 20,

    /*
     * The key of the page[x] query string parameter for page number.
     */
    'number_parameter' => 'pageNo',

    /*
     * The key of the page[x] query string parameter for page size.
     */
    'size_parameter' => 'pageSize',

    /*
     * The name of the macro that is added to the Eloquent query builder.
     */
    'method_name' => 'jsonPaginate',

    /*
     * Here you can override the base url to be used in the link items.
     */
    'base_url' => null,

    /*
     * The name of the query parameter used for pagination
     */
    'pagination_parameter' => 'pageNo',
];