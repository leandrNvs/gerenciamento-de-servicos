<?php

namespace Src\Foundation;

use Src\Exceptions\ValidateException;
use Src\Routing\Redirect;
use Throwable;

class ExceptionHandler
{
    
    public function listen()
    {
        set_exception_handler(function(Throwable $exception) {
            if($exception instanceof ValidateException) {
                Redirect::back();
            }

            die($exception->getMessage());
        });
    }

}

