<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirType extends Model
{

    public function airData()
    {
        return $this->hasMany('App\AirData', 'air_type_id', 'id');
    }

}
