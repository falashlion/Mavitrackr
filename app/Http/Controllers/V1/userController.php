<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{

    /*public function __construct(){
        $this->middleware('auth:api');
    }
    */
    public function index(){
       $users = users::all();
        return response()->json([
            'status' => 'success',
            'users' => $users,
        ]);
        $users = DB::table('users')->paginate(10);
        return view('users.index', ['users' => $users]);
    }
    public function store(){

        }

    public function show(){

            }

    public function update(){

                }
    public function destroy(){
        }

}
