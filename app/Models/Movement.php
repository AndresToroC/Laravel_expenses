<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'sub_category_id', 'description', 'value', 'date', 'hour'
    ];

    public function sub_category() {
        return $this->belongsTo(SubCategory::class);
    }
}
