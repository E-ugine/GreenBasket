<?php
namespace App\Models;

use App\Models\User;
    
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Order extends Model
    {
        use SoftDeletes;

        protected $fillable = [
            'product_id', 'user_id', 'quantity', 'address' 
        ];

        public function user()
        {
            return $this->belongsTo(User::class, 'user_id');
        }

        public function product()
        {
            return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
        }

    }