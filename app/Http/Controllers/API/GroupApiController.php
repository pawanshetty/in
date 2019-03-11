<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use Exception;
use App\Models\Group;

class GroupApiController extends Controller
{
    protected $groupService;

    public function __construct()
    {
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

        return Response::json([
            'groups' => $groups
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
            'name'=>'required|unique:groups',
        ]);
        
        try
        {
            $group = $this->groupService->storeGroup($request);
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();

            return Response::json([
                'message' => $message
            ], 404);
        }

        return Response::json([
            'group' => $group
        ], 201);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $group = Group::findOrFail($id);
        }
        catch(Exception $e)
        {
            return Response::json([
                'message' => "Group Not found"
            ], 404);
        }
        

        $group_name = $request->get('name');

        if($group_name != $group->name)
        {
            $request->validate([
                'name'=>'required|unique:groups'
            ]);
        }
        
        try
        {
            $group = $this->groupService->updateGroup($request,$id);
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();

            return Response::json([
                'message' => $message
            ], 404);
        }
        

        return Response::json([
            'group' => $group
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
        $this->groupService->deleteGroup($id);
        
        return Response::json([
            'message' => "deleted"
        ], 201);
    }
}
