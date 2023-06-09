<?php

namespace App\Http\Controllers;

use App\Models\CareerDevelopmentApplication;
use App\Http\Requests\StoreCareerDevelopmentApplicationRequest;
use App\Http\Requests\UpdateCareerDevelopmentApplicationRequest;

class CareerDevelopmentApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return CareerDevelopmentApplication::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCareerDevelopmentApplicationRequest $request)
    {
        return CareerDevelopmentApplication::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(CareerDevelopmentApplication $careerDevelopmentApplication = null, $id)
    {
        return CareerDevelopmentApplication::findOrFail($id);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CareerDevelopmentApplication $careerDevelopmentApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCareerDevelopmentApplicationRequest $request, CareerDevelopmentApplication $careerDevelopmentApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CareerDevelopmentApplication $careerDevelopmentApplication)
    {
        //
    }
}
