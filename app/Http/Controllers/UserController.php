<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Storerequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{   
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(Storerequest $request)
    {
        $data = $request->validated();
        try {
            // Call the createUser method on the user service
            $users = $this->userService->createUser($data);
            // Return a successful response
            return redirect('/users/success')
                     ->with('message', 'User created successfully! Hello ' . $users->first_name);

        } catch (\Exception $e) {
            // Handle exceptions (e.g., user creation failed)
            return back()->withErrors(['error' => 'User creation failed: ' . $e->getMessage()])->withInput();;
        }
    }

    public function listUsers(Request $request)
    {
        $users = User::all();
        return view('success', compact('users'));
    }
}
