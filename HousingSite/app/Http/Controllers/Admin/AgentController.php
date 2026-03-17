<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Blacklist;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Auth;


class AgentController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    /**
     * List agents with optional search / status filter.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        $status = $request->query('status');

        $query = Agent::with('user', 'blacklist');

        if ($q) {
            $query->whereHas('user', function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })->orWhere('company_name', 'like', "%{$q}%")
              ->orWhere('license_number', 'like', "%{$q}%");
        }

        if (in_array($status, ['pending','verified','rejected'])) {
            $query->where('verification_status', $status);
        }

        $agents = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('dashboard.admin.agents.index', compact('agents','q','status'));
    }

    /**
     * Show an agent's details.
     * Route model binding will use Agent::$primaryKey (agent_id).
     */
    public function show(Agent $agent)
    {
        $agent->load('user', 'listings', 'blacklist');
        return view('dashboard.admin.agents.show', compact('agent'));
    }

    /**
     * Approve or reject agent verification.
     * Accepts POST with 'action' => 'approve'|'reject' and optional 'note'.
     */
    public function review(Request $request, Agent $agent)
    {
        $data = $request->validate([
            'action' => 'required|in:approve,reject',
            'note'   => 'nullable|string|max:2000',
        ]);

        $agent->verification_status = $data['action'] === 'approve' ? 'verified' : 'rejected';
        $agent->save();

        // Optionally store the note into the blacklist reason if rejected (non-destructive)
        if ($data['action'] === 'reject' && !empty($data['note'])) {
            // create/update blacklist record but mark as not blacklisted (so it's just a rejection note)
            Blacklist::updateOrCreate(
                ['agent_id' => $agent->agent_id],
                [
                    'reason' => $data['note'],
                    'status' => 'note', // if your blacklist table has a status column; otherwise drop
                    'actioned_by' => Auth::id(),
                ]
            );
        }
         if ($data['action'] === 'approve') {
        return redirect()->route('admin.agents.show', $agent)
            ->with('success', 'Agent verification approved.')
            ->with('verified_notification', true);
    }

        return redirect()->route('admin.agents.show', $agent)->with('success', 'Agent verification updated.');
    }

    /**
     * Blacklist or un-blacklist an agent using the Blacklist model/table.
     * Accepts POST with 'blacklist' => '1'|'0', 'reason' => string
     */
    public function blacklist(Request $request, Agent $agent)
    {
        $data = $request->validate([
            'blacklist' => 'required|in:0,1',
            'reason'    => 'nullable|string|max:2000',
        ]);

        $blacklistFlag = (int) $data['blacklist'];

        if ($blacklistFlag === 1) {
            // create or update blacklist record
            $record = Blacklist::updateOrCreate(
                ['agent_id' => $agent->agent_id],
                [
                    'reason' => $data['reason'] ?? 'No reason provided.',
                    'actioned_by' => Auth::id(),
                    'blacklisted_at' => now(),
                    // add other columns if your blacklist table has them
                ]
            );
            $message = 'Agent has been blacklisted.';
        } else {
            // Remove blacklist record or mark it inactive depending on your schema
            $record = Blacklist::where('agent_id', $agent->agent_id)->first();
            if ($record) {
                // if you prefer to keep history, set a 'removed_at' column instead of delete
                if (schemaHasColumn('blacklist', 'removed_at')) {
                    $record->removed_at = now();
                    $record->actioned_by = Auth::id();
                    $record->save();
                } else {
                    $record->delete();
                }
            }
            $message = 'Agent has been un-blacklisted.';
        }

        return redirect()->route('admin.agents.show', $agent)->with('success', $message);
    }
}

/**
 * Helper: naive check for schema column existence.
 * If you prefer, remove and rely on strict schema knowledge.
 */
function schemaHasColumn($table, $column) {
    try {
        return \Illuminate\Support\Facades\Schema::hasColumn($table, $column);
    } catch (\Exception $e) {
        return false;
    }
}
