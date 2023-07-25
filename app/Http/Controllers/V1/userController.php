<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\users;
use Illuminate\Http\Request;

class userController extends Controller
{

    public function index(){
        return users::all();
    }
}
