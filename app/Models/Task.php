<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_completed',
        'start_at',
        'expired_at',
        'user_id',
        'company_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
        'company_id',
        'user_object'
    ];


    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user_object()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
