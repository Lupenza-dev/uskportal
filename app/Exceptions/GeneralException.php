<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class GeneralException extends Exception
{
    protected $code = 422;
  
    public function report()
    {
        //
    }

   
    public function render($request)
    {
        return Response::json([
            'messagee' => $this->getMessage(),
            'code' => $this->getCode(),


        ], $this->getCode());
    }
}
