<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view user', ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['create','store']]);
        $this->middleware('permission:update user', ['only' => ['update','edit']]);
        $this->middleware('permission:delete user', ['only' => ['destroy']]);
    }


    /**
     * Display all users
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view('users.index', [
            'users' => $users
        ]);
    }


    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('users.create');
        $roles = Role::pluck('name','name')->all();

        return view('users.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created user
     * 
     * @param User $user
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Request $request, $roleId)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required'
    
        ]);

        $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);

        return redirect('users')->with('status', 'User Created Successfully with roles');
    }
    


    /**
    * Edit user data
    * 
    * @param User $user
    * 
    * @return \Illuminate\Http\Response
    */
    public function edit(User $user)
    {
        $roles = Role::pluck('name','name')->all();
        $userRoles = $user->roles->pluck('name','name')->all();

        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
            
        ]);
    }
    


     /**
     * Update user data
     * 
     * @param User $user
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required'
    
        ]);  
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $data += [
                'password' => Hash::make($request->password),
            ];
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect('users')->with('status', 'User Updated Successfully with roles');
    }


    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect('users')->with('status', 'User Deleted Succesfully');
    }


    
    
} 
