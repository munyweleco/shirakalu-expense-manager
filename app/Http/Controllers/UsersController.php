<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
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

    /**
     * Show edit form for user
     * @SuppressWarnings("php:s103")
     **/
    public function edit(User $user): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('users.edit', compact('user'));
    }

    // Update user details
    public function update(Request $request, User $user): RedirectResponse
    {
        $user->update($request->all());
        return redirect()->route('users.show', $user)->with('success', 'User updated successfully');
    }

    // Delete user
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
