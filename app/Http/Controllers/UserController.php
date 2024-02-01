<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\DataTables\UsersDataTable;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(CreateUserRequest $request)
    {
        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ];

        $user = User::create($userData);

        $user->phone()->create([
            'phone' => $request->input('phone'),
        ]);

        return redirect()->route('user.index');
    }

    public function index(UsersDataTable $dataTable)
    {
        $users = User::all();
        // dd($users);
        return $dataTable->with('users', $users)->render('user.index');
    }
}
