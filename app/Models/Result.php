<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'test_id',
        'status',
        'start_time',
        'end_time',
    ];

    protected $dates = ['start_time', 'end_time'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function tests()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
