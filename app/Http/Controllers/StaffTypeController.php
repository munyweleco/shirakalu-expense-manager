<?php

namespace App\Http\Controllers;

use App\DataGrids\StaffTypeDataGrid;
use App\DataTables\StaffTypeDataTable;
use App\Models\StaffType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StaffTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StaffTypeDataTable $dataTable)
    {
        return $dataTable->render('staff-type.index');
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
        StaffType::create($request->all());

        return redirect()->route('staff-type.index')
            ->with('success', 'Staff created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $staff = StaffType::findOrFail($id);
        return view('staff-type.show', ['staff' => $staff]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $staff = StaffType::findOrFail($id);
        return view('staff-type.edit', ['staff' => $staff]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $staff = StaffType::findOrFail($id);
        $staff->update($request->all());
        return redirect()->route('staff-type.index')
            ->with('success', 'Staff updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $post = StaffType::findOrFail($id);
        $post->delete();
        return redirect()->route('staff-type.index')
            ->with('success', 'Staff deleted successfully');
    }
}
