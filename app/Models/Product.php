<?php
    namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Product extends Model
    {
        use SoftDeletes;

        protected $fillable = [
            'name', 'price', 'quantity', 'description', 'image'
        ];

        public function orders(){
            return $this->belongsToMany(Order::class)->withPivot('quantity')->withTimestamps();
        }
    }