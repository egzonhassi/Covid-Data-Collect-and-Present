<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    protected $fillable = ['state_id' , 'confirmed' , 'deaths' , 'recovered' , 'date'];

    public function state()
    {
        return $this->belongsTo('App\State');
    }
}
