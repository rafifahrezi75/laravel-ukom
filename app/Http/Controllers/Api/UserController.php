<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UkomResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all users
        $users = User::latest()->paginate(5);

        //return collection of users as a resource
        return new UkomResource(true, 'List Data User', $users);
    }

    /**
     * indexuser
     *
     * @return void
     */
    public function indexuser()
    {
        //get all users
        $users = User::latest()->get();

        //return collection of users as a resource
        return new UkomResource(true, 'List Data User', $users);
    }

}
