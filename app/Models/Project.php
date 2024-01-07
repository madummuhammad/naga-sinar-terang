<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
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
    return $this->hasMany('App\Models\Material');
  }

}
