<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Traits\Helper;
class Controller extends BaseController
{
    use Helper;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   

    public function employeer(){
        if (isset(Auth::guard('employee')->user()->name)) {
            return Auth::guard('employee')->user()->name;
        }
    }

    public function admin(){
        if (isset(Auth::guard('admin')->user()->name)) {
            return Auth::guard('admin')->user()->name;
        }
    }

    public function staff(){
        if (isset(Auth::guard('cook')->user()->name)) {
            return Auth::guard('cook')->user()->name;
        }
    }
}
