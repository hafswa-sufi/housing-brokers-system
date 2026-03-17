<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use App\Models\Reports;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Reports::with(['reporter', 'reportedUser'])->latest()->get();
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('reports.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reported_user_id' => 'required|exists:users,id',
            'reason' => 'required|string|max:500',
            'description' => 'required|string|max:1000',
        ]);

        // Check if user is reporting themselves
        if ($request->reported_user_id == Auth::id()) {
            return back()->with('error', 'You cannot report yourself.');
        }

        // Check if report already exists for same user
        $existingReport = Reports::where('reporter_id', Auth::id())
            ->where('reported_user_id', $request->reported_user_id)
            ->first();

        if ($existingReport) {
            return back()->with('error', 'You have already reported this user.');
        }

        Reports::create([
            'reporter_id' => Auth::id(),
            'reported_user_id' => $request->reported_user_id,
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->route('reports.index')->with('success', 'Report submitted successfully.');
    }

    public function updateStatus(Request $request, Reports $report)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $report->update(['status' => $request->status]);

        // If approved, add to blacklist
        if ($request->status == 'approved') {
            Blacklist::firstOrCreate([
                'user_id' => $report->reported_user_id,
                'reason' => $report->reason,
                'reported_by' => Auth::id(),
            ]);
        }

        return back()->with('success', 'Report status updated successfully.');
    }
}
