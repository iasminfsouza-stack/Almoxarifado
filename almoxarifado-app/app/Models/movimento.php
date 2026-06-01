<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Model\Produto;

class movimento extends Model
{
    protected $fillable = [
        'produto_id', 'quantidade', 'tipo'
    ];

    public function produto()
    {
        return $this -> belongsto(produto :: class, 'produto_id');
    }
}
