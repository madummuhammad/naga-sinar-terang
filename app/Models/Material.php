<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Material extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $guarded = [];

  public $incrementing = false;
  protected $keyType = "string";

  protected static function boot() {
    parent::boot();
    static::creating(function ($model) {
      $model->id = (string) Str::uuid();
    });
  }

  public function stock()
  {
    return $this->belongsTo('App\Models\Stock','id','material_id');
  }

  public function production()
  {
    return $this->hasMany('App\Models\Stock')->where('stock_location','production');
  }

  public function qc()
  {
    return $this->hasMany('App\Models\Stock')->where('stock_location','qc');
  }

  public function receiver()
  {
    return $this->hasMany('App\Models\Stock')->where('stock_location','receiver');
  }

  public function ncp()
  {
    return $this->hasMany('App\Models\Stock')->where('stock_location','ncp');
  }

  public function fg()
  {
    return $this->hasMany('App\Models\Stock')->where('stock_location','delivery');
  }
}
