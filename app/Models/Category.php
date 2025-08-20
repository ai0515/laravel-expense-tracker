<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = array('id');

    public static $rules = array(
        'category' => 'required|min:1|max:20'
    );

    protected $fillable = ['category'];

    public function transactions()
    {
       return $this->belongsToMany(Transaction::class, 'category_transaction', 'category_id', 'transaction_id');
    }
}
