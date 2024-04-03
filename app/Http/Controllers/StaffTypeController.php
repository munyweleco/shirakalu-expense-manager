<?php

namespace App\Http\Controllers;

use App\Models\StaffType;
use Illuminate\Http\Request;

class StaffTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffList = StaffType::all();
        return view('staff-type.index', compact('staffList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff-type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $staff = StaffType::findOrFail($id);
        return view('staff-type.edit', ['staff' => $staff]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = StaffType::findOrFail($id);
        $post->delete();
        return redirect()->route('staff-type.index')
            ->with('success', 'Staff deleted successfully');
    }
}
