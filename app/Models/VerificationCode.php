<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;

    protected $table = 'verification_codes';
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $fillable = [
        'user_id',
        'code',
        'expired_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $dateTimes = [
        "expired_at",
    ];
}
