<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use DB;
use Exception;

class GroupService{

    public function showAll()
    {
        return Group::all();
    }
    
    public function storeGroup(Request $request)
    {
        $group = new Group([
            'name' => $request->get('name')
        ]);

        $users = $request->input('users');
        
        if(count($users) > 0)
        {
            foreach($users as $user)
            {
                if($user != null){
                    try
                    {
                        User::findOrFail($user);
                    }
                    catch(Exception $e)
                    {
                        throw new \League\Flysystem\Exception("User not found:  ".$user);
                    }
                }
            }
        }

        DB::transaction(function() use($group,$users) {
            $group->save();
            
            $group->users()->attach($users);
        });

        return $group;
    }

    public function updateGroup(Request $request,$id)
    {
        $users = $request->input('users');

        $group = Group::find($id); 

        if(count($users) > 0)
        {
            foreach($users as $user)
            {
                if($user != null){
                    try
                    {
                        User::findOrFail($user);
                    }
                    catch(Exception $e)
                    {
                        throw new \League\Flysystem\Exception("User not found:  ".$user);
                    }
                }
            }
        }

        DB::transaction(function () use($group,$users,$id,$request) {
            $group = Group::find($id);
            
            $group->name = $request->get('name') ?? $group->name;
            $group->save();

            $group->users()->sync($users);
            
            return $group;
        });
    }
    
    public function deleteGroup($id)
    {
        $group = Group::find($id);
    
        if( count($group->users) > 0 )
        {
            $group->users()->detach();
        }
        
        $group->delete();

        return true;
    }

}