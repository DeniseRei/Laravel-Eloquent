<?php

namespace App\Accessors;

/*Quando tiver accessors comum no sistema*/

trait DefaultAccessors
{
    public function getTitleAttribute($title)
    {
        return strtoupper($title);
    }

    /*Titulo + body, da pra fazer full name por exemplo*/

    public function getTitleAndBodyAttribute()
    {
        return $this->title . ' - ' . $this->body;
    }
}
