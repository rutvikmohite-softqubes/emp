<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'gender',
        'mobile_number',
        'email',
        'blood_group',
        'parent_name',
        'relation',
        'parent_mobile_number',
        'permanent_address1',
        'permanent_address2',
        'permanent_city_id',
        'permanent_state_id',
        'permanent_pincode',
        'current_address1',
        'current_address2',
        'current_city_id',
        'current_state_id',
        'current_pincode',
    ];

    protected $casts = [
        'gender' => 'string',
        'blood_group' => 'string',
        'relation' => 'string',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permanentCity()
    {
        return $this->belongsTo(City::class, 'permanent_city_id');
    }

    public function permanentState()
    {
        return $this->belongsTo(State::class, 'permanent_state_id');
    }

    public function currentCity()
    {
        return $this->belongsTo(City::class, 'current_city_id');
    }

    public function currentState()
    {
        return $this->belongsTo(State::class, 'current_state_id');
    }
}
