<?php

namespace App\Http\Controllers;

use App\Models\StaffType;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class StaffTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $staffList = StaffType::all();
        return view('staff-type.index', compact('staffList'));
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
    public function show(StaffType $staffType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaffType $staffType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaffType $staffType)
    {
        //
    }
}
