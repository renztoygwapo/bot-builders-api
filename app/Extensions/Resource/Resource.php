<?php

namespace App\Extensions\Resource;

use App\Helpers\ArrayHelper;
use App\Helpers\StringHelper;
use App\Interfaces\Resource as ResourceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class Resource extends ModifiedJsonResource implements ResourceInterface
{
    public $response;

    /**
     * Call all requested includes if the include belings to Available includes.
     */
    public function callIncludes()
    {
        // Determine if request has includes
        $includes = ArrayHelper::isset($this->request, 'includes') ? explode(',', $this->request['includes']) : [];
        // Determine if resource has available includes
        $availableIncludes = $this->availableIncludes ? $this->availableIncludes : [];
        // Handle Includes
        foreach ($includes as $include) {
            // Determine if specified include belongs to available includes
            if (in_array($include, $availableIncludes)) {
                // Format the available include to match the method name
                $str = StringHelper::slugToCamelCase($include, '_');
                // Call include method
                $this->response[$include] = $this->callInclude('include'.$str);
            }
        }
    }

    /**
     * Determine specified include if is existed and call it.
     *
     * @param string method name
     * @return include response
     */
    public function callInclude(string $include)
    {
        // Determine if the include method is not existed
        if (! method_exists($this, $include)) {
            throw new Exception('Specified Include not found.', 1);
        }

        return call_user_func([$this, $include]);
    }

    /**
     * Get called includes to merge with resource response.
     *
     * @return $mixed value
     */
    public function resource()
    {
        // Dont call includes if resource is called from another resource
        if (! parent::$call_from_resource) {
            $this->request = \Request::all();
            $this->callIncludes();
        }

        return $this->response;
    }
}
