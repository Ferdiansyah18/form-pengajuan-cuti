<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\LeaveBalance;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $currentYear = date('Y');

        $balance = LeaveBalance::firstOrCreate(
            ['user_id' => $user->id, 'year' => $currentYear],
            ['previous_leave_balance' => 0, 'current_leave_balance' => 12]
        );

        $requests = \App\Models\LeaveRequest::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('employee.dashboard', compact('balance', 'requests'));
    }

    public function create()
    {
        return view('employee.apply');
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'category' => 'required|array',
            'reason' => 'required|string',
            'tanggal_pengajuan_cuti' => 'required|date',
            'tanggal_cuti' => 'required|string', // Comma separated or single string
            'signature' => 'required|string'
        ]);

        // Process Signature
        $signatureData = $request->signature; // base64 string
        $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
        $signatureData = str_replace(' ', '+', $signatureData);
        $signatureName = 'signature_'.time().'_'.Auth::id().'.png';
        \Illuminate\Support\Facades\Storage::disk('public')->put('signatures/'.$signatureName, base64_decode($signatureData));

        // Create Request
        \App\Models\LeaveRequest::create([
            'user_id' => Auth::id(),
            'category' => json_encode($request->category),
            'reason' => $request->reason,
            'tanggal_pengajuan' => $request->tanggal_pengajuan_cuti,
            'tanggal_cuti' => json_encode(explode(',', $request->tanggal_cuti)),
            'signature_path' => 'signatures/'.$signatureName,
            'status' => 'pending'
        ]);

        return redirect()->route('employee.dashboard')->with('success', 'Form Pengajuan Berhasil Dikirim!');
    }
}
