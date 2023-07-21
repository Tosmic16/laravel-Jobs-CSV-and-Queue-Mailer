<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;
   public $timestamp = FALSE;
   const CREATED_AT = null;
   const UPDATED_AT = null;
}
