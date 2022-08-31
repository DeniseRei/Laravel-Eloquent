<?php

namespace App\Models;

use App\Accessors\DefaultAccessors;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes, DefaultAccessors;

    protected $fillable = ['user_id', 'title', 'body', 'date'];

    /*Accessor*/

    /*Titulo do post em maiusculo*/
   /*  public function getTitleAttribute($title)
    {
        return strtoupper($title);
    }

    /*Titulo + body, da pra fazer full name por exemplo*/

   /*  public function getTitleAndBodyAttribute()
    {
        return $this->title . ' - ' . $this->body;
    } */
}
