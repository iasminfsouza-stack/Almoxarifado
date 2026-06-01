<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Movimento;

class produto extends Model
{
    protected $fillable = [
       'nome', 'marca', 'estoque', 
    ];

    public function movimentos ()
    {
        return $this -> hasmany(movimento:: class);
    }

}
