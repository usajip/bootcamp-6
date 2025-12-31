<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = ['user_id', 'product_id', 'quantity', 'total_price', 'status'];
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction_item()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
