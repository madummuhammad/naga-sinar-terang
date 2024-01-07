<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Stock extends Model
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

  public function material()
  {
    return $this->belongsTo('App\Models\Material','material_id','id');
  }

  public function project()
  {
    return $this->belongsTo('App\Models\Project');
  }
}
