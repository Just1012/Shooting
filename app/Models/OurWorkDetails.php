<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurWorkDetails extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function ourWork(){
        return $this->belongsTo(OurWork::class,'our_work_id');
    }
}
