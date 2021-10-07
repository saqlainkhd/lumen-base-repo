<?php

if (! function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}


function getIds($value)
{
    return array_map('intval', explode(',', $value));
}

function pageLimit($request) : int
{
    return ($request->filled('page_limit') && is_numeric($request->input('page_limit'))) ? $request->input('page_limit') : config("build_one.page_limit");
}
