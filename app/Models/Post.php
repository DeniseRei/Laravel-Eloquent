<?php

namespace App\Models;

use App\Accessors\DefaultAccessors;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use HasFactory, SoftDeletes, DefaultAccessors;

    protected $fillable = ['user_id', 'title', 'body', 'date'];

    /*Especificar a tipagem*/
    protected $casts = [
        'date' => 'datetime:d/m/Y',
        //active => 'boolean',
    ];

    /*Accessor* = Acessor -> Altera os dados no momento de recuperar do banco./

    /*Casting* = Casts -> Faz o casting automatico do tipo no momento de persistir no banco.*/
    /* public function getDateAttribute($date)
    {
        return Carbon::make($date)->format('d/m/Y');
    } */

    /* Mutator -> Altera os dados no momento de persistir no banco.*/

    public function setDateAttributte($value)
    {
        $this->attributes['date'] = Carbon::make($value)->format('Y-m-d');
    }

    /* Titulo do post em maiusculo */
    public function getTitleAttribute($title)
    {
        return strtoupper($title);
    }

    /* Titulo + body, da pra fazer full name por exemplo*/
    public function getTitleAndBodyAttribute()
    {
        return $this->title . ' - ' . $this->body;
    }
    /*Locas Scope*/
    public function scopeLastWeek($query)
    {
        return $this->whereDate('date', '>=', now()->subDays(4))
            ->whereDate('date', '<=', now()->subDays(1));
    }

    public function scopeToday($query)
    {
        return $this->whereDate('date', now());
    }

    public function scopeBetween($query, $firstDate, $lastDate)
    {
        $firstDate = Carbon::make($firstDate)->format('Y-m-d');
        $lastDate = Carbon::make($lastDate)->format('Y-m-d');

        return $this->whereDate('date', '>=', $firstDate)
        ->whereDate('date', '<=', $lastDate);
    }

    /*Anonymous Global Scope*/
    protected static function booted()
    {
        static::addGlobalScope('year', function(Builder $builder ){
            $builder->whereYear('date', Carbon::now()->year);
        });
    }
}
