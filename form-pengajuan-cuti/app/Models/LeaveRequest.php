<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'reason',
        'tanggal_pengajuan',
        'tanggal_cuti',
        'signature_path',
        'status',
        'hrd_notes',
        'security_notes',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_cuti' => 'array',
            'tanggal_pengajuan' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
