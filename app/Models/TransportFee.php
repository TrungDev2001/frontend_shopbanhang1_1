<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportFee extends Model
{
    protected $guarded = [];
    public function ThanhPho()
    {
        return $this->belongsTo(ThanhPho::class, 'thanhpho');
    }
    public function QuanHuyen()
    {
        return $this->belongsTo(QuanHuyen::class, 'quanhuyen');
    }
    public function XaPhuong()
    {
        return $this->belongsTo(XaPhuong::class, 'xaphuong');
    }
}
