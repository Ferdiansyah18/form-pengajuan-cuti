<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Illuminate\Support\Facades\Auth;

class HrdController extends Controller
{
    public function dashboard(Request $request)
    {
        $query = LeaveRequest::with('user')->orderBy('created_at', 'desc');

        // Search by Employee Name
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by Month
        if ($request->filled('month')) {
            $query->whereMonth('tanggal_pengajuan', $request->month);
        }

        // Filter by Year
        if ($request->filled('year')) {
            $query->whereYear('tanggal_pengajuan', $request->year);
        }

        $requests = $query->get();
        return view('hrd.dashboard', compact('requests'));
    }

    public function show($id)
    {
        $leaveRequest = LeaveRequest::with('user')->findOrFail($id);
        return view('hrd.review', compact('leaveRequest'));
    }

    public function update(Request $request, $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'hrd_notes' => 'nullable|string',
            'security_notes' => 'nullable|string',
        ]);

        $leaveRequest->update([
            'status' => $request->status,
            'hrd_notes' => $request->hrd_notes,
            'security_notes' => $request->security_notes,
        ]);

        // If approved, deduct balance
        if ($request->status === 'approved' && $leaveRequest->wasChanged('status')) {
            $dates = json_decode($leaveRequest->tanggal_cuti, true);
            $daysToDeduct = is_array($dates) ? count($dates) : 1;

            $balance = LeaveBalance::firstOrCreate(
                ['user_id' => $leaveRequest->user_id, 'year' => date('Y')],
                ['previous_leave_balance' => 0, 'current_leave_balance' => 12]
            );

            // Deduct logic: prioritize previous balance
            if ($balance->previous_leave_balance >= $daysToDeduct) {
                $balance->previous_leave_balance -= $daysToDeduct;
            } else {
                $remainingToDeduct = $daysToDeduct - $balance->previous_leave_balance;
                $balance->previous_leave_balance = 0;
                $balance->current_leave_balance -= $remainingToDeduct;
            }
            $balance->save();
        }

        return redirect()->route('hrd.dashboard')->with('success', 'Status pengajuan berhasil diperbarui!');
    }
}
