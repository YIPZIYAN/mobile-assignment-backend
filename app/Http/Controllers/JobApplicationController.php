<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Http\Requests\StoreJobApplicationRequest;
use App\Http\Requests\UpdateJobApplicationRequest;
use App\Models\JobPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return JobApplication::with('jobPost.company')
            ->where('user_id', Auth::user()->id)
            ->orderByDesc('updated_at')
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobApplicationRequest $request)
    {
        JobApplication::create($request->all());
    }

    /**
     * Display the specified resource.
     * Show applicants list
     */
    public function show(JobApplication $jobApplication = null, $id)
    {
        $jobPost = JobPost::findOrFail($id);

        $users= $jobPost->users()
        ->without('company')
        ->orderByDesc('job_applications.created_at')->get();

        $users->each(function ($user) {
          $date  = Carbon::parse($user->pivot->created_at)->diffForHumans();
          $user->pivot->applied_at = $date;
        });

        return response()->json($users);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobApplication $jobApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobApplicationRequest $request, JobApplication $jobApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplication $jobApplication)
    {
        //
    }

    public function acceptApplication($id)
    {
        $jobInterview = JobApplication::findOrFail($id);
        $jobInterview->update([
            'status' => 'accept',
        ]);

        return response()->json();
    }

    public function declineApplication($id)
    {
        $jobInterview = JobApplication::findOrFail($id);
        $jobInterview->update([
            'status' => 'declined',
        ]);

        return response()->json();
    }
}
