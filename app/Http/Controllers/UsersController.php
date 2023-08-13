<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;

class UsersController extends Controller
{

    public function list()
    {

        return view('users.list', [
            'users' => User::all()
        ]);

    }

    public function details($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        return response()->json($user, 200);
    }
    

    public function addForm()
    {

        return view('users.add');

    }
    
    public function add()
    {

        $attributes = request()->validate([
            'first' => 'required',
            'last' => 'required',
            'email' => 'required|email|unique:users',
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
            'password' => 'required',
        ]);

        $user = new User();
        $user->first = $attributes['first'];
        $user->last = $attributes['last'];
        $user->email = $attributes['email'];
        $user->linkedin = $attributes['linkedin'];
        $user->github = $attributes['github'];
        $user->password = $attributes['password'];
        $user->save();

        return redirect('/console/users/list')
            ->with('message', 'User has been added!');

    }

    public function editForm(User $user)
    {

        return view('users.edit', [
            'user' => $user,
        ]);

    }

    public function edit(User $user)
    {

        $attributes = request()->validate([
            'first' => 'required',
            'last' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
            'password' => 'nullable',
        ]);

        $user->first = $attributes['first'];
        $user->last = $attributes['last'];
        $user->email = $attributes['email'];
        $user->linkedin = $attributes['linkedin'];
        $user->github = $attributes['github'];

        if($attributes['password']) $user->password = $attributes['password'];

        $user->save();

        return redirect('/console/users/list')
            ->with('message', 'User has been edited!');

    }

    public function delete(User $user)
    {

        if($user->id == auth()->user()->id)
        {
            return redirect('/console/users/list')
                ->with('message', 'Cannot delete your own user account!');        
        }
        
        $user->delete();

        return redirect('/console/users/list')
            ->with('message', 'User has been deleted!');                
        
    }
    
}
