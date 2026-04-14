<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveAssignment extends Model
{
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'days_allocated',
        'days_used',
        'year',
    ];

    protected $casts = [
        'days_allocated' => 'integer',
        'days_used' => 'integer',
        'year' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }
}
