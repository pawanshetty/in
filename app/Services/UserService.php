<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use DB;
use Exception;

class UserService{

    public function showAll()
    {
        return User::all();
    }

    public function storeUser(Request $request)
    {
        $user = new User([
            'name' => $request->get('name'),
            'email'=> $request->get('email'),
            'password'=> bcrypt($request->get('password')),
            'role_id' => $request->get('role')
        ]);

        $groups = $request->input('groups');
        
        foreach($groups as $group)
        {
            if($group != null){
                try
                {
                    Group::findOrFail($group);
                }
                catch(Exception $e)
                {
                    throw new Exception('Group Not Found '+$group);
                }
            }
        }
        
        DB::transaction(function ()  use($user,$groups,$request) {

            $user->save();
            $user->groups()->attach($groups);

            // Set the image if the field exists
            if ($request->has('avatar')) {
                $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
            }
        });

        return $user;
    }

    public function updateUser(Request $request,$id)
    {
        $groups = $request->input('groups') ?? [];
    
        foreach($groups as $group)
        {
            try{
                Group::findOrFail($group);
            }catch(Exception $e){
                
                throw new Exception('Group Not Found '+$group);
            }
        }

        DB::transaction(function ()  use($id,$groups,$request) {

            $user = User::find($id);
            
            $user->name = $request->get('name') ?? $user->email;
            $user->email = $request->get('email') ?? $user->email;
            $user->role_id = $request->get('role');
            $user->password = $request->get('password') ? bcrypt($request->get('password')):$user->password;
            $user->save();
            
            $user->groups()->sync($groups);

            return $user;
        });
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        
        if( count($user->groups) > 0 ){
            $user->groups()->detach();
        }
        
        $user->delete();

        return true;
    }


}