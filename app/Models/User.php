<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
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
}
