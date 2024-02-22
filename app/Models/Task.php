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

    // Defines the value of the user attribute with its name
    public function getUserAttribute()
    {
        return $this->user_object->name;
    }

    // Add the attribute with the username
    protected $appends = ['user'];

    // Rearranges the position of model attributes
    public function toArray()
    {
        $array = parent::toArray();
        $user = $array['user'];
        unset($array['user']);
        $position = 3;
        $result = array_slice($array, 0, $position, true) +
            ['user' => $user] +
            array_slice($array, $position, null, true);
        return $result;
    }
}
