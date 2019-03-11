<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
/**
 * Controller 
 */
class GroupController extends Controller
{
    private $groupService;
    /**
     * Ensure that the user role cannot do any crud operation
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:user', ['except' => ['index']]);
        $this->groupService = app('GroupService');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */   
    public function index()
    {
        $groups = $this->groupService->showAll();

        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('groups.create');
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
            'name'=>'required|unique:groups',
        ]);

        $groups = $request->input('users');

        //flatten if sent as multi dimensional array
        $groups = new RecursiveIteratorIterator(new RecursiveArrayIterator($groups));

        $this->groupService->storeGroup($request,$groups);
 
        return redirect('/groups')->with('success', 'Group has been created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::find($id);
        
        if($group == null){
            return " no user";
        }
        
        return view('groups.edit', compact('group'));
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
        $group = Group::find($id);
        $group_name = $request->get('name');

        if($group_name != $group->name){
            $request->validate([
                'name'=>'required|unique:groups'
            ]);
        }

        $this->groupService->updateGroup($request,$id);
    
        return redirect('/groups')->with('success', 'Group:'.$group->name.' has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->groupService->deleteGroup($id);

        return redirect('/groups')->with('success', 'Group has been deleted Successfully');
    }
}
