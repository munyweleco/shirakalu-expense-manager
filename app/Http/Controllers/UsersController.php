<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }

    // Show user details
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Show edit form for user
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update user details
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show', $user)->with('success', 'User updated successfully');
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
