<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Response;
use App\Http\Controllers\Controller;
use Exception;
use App\Models\User;

class UserApiController extends Controller
{
    protected $userService;

    public function __construct()
    {
        $this->userService = app('UserService');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userService->showAll();
        
        return Response::json([
            'users' => $users
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=> 'required|email|unique:users,email',
            'password' => 'required'
        ]);
       
        try{
            $user = $this->userService->storeUser($request);
        }catch(Exception $e){
            return Response::json([
                'message' => "group not found"
            ], 500);
        }

        return Response::json([
            'users' => $user
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
      
        if($user == null){
            return Response::json([
                'message' => "User not found"
            ], 404);
        }

        try
        {
            $user = $this->userService->updateUser($request,$id);
        }
        catch(Exception $e)
        {
            return Response::json([
                'message' => "Group not found"
            ], 404);
        }
        
        return Response::json([
            'users' => $user
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            User::findOrFail($id);
        }
        catch(Exception $e)
        {
            return Response::json([
                'message' => "User not found"
            ], 404);
        }
        
        $this->userService->deleteUser($id);

        return Response::json([
            'message' => "Successfully deleted"
        ], 201);
    }
}
