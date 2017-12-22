<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class MsgController extends Controller
{
    public function msg($status){
        return $status;
    }
}
