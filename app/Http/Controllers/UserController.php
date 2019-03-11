<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    private $userService;

    /**
     * ensure that the user role cannot do any of the crud operation
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:user', ['except' => ['index']]);
        
        $this->userService = app('UserService');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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

        $this->userService->storeUser($request);

        return redirect('/users')->with('success', 'User has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if($user == null){
            return redirect('/users')->with('failure', 'No such user');
        }

        return view('users.edit', compact('user'));
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

        if($user->email != $request->input('email'))
        {
            $request->validate([
                'name'=>'required',
                'email'=> 'required|email|unique:users,email',
              ]);
        }else{
            $request->validate([
                'name'=>'required',
                'email'=> 'required'
              ]);
        }
        
        $this->userService->updateUser($request,$id);

        return redirect('/users')->with('success', 'User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userService->deleteUser($id);

        return redirect('/users')->with('success', 'User been deleted Successfully');
    }
}
