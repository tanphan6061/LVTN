<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'addresses';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function booted()
    {
        static::addGlobalScope(new ActiveScope());
    }
}
