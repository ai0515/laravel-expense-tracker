<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = array('id');

    public static $rules = array(
        'payment_method' => 'required|min:1|max:20'
    );

    protected $fillable = ['payment_method'];
}
