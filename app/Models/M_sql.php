<?php

namespace App\Models;

use CodeIgniter\Model;

class M_sql extends Model
{
    protected $table = 'order_shearing';
    protected $primaryKey = 'id';
    public $useAutoIncrement = true;

    protected $allowedFields = [
        'shearing_number',
        'order_type',
        'quantity',
        'order_number',
        'payload',
        'status',
        'result',
        'created_at',
        'nik'
    ];
}

?>