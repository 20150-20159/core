<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int user_id
 * @property int transfer_user_id
 * @property false|mixed|string deed
 * @property array|mixed|string|null size
 * @property array|mixed|string|null address
 */
class Property extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'size',
        'address'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
