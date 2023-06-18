<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Match is a reserved PHP key so let's use MatchResult instead
 */
class MatchResult extends Model
{
    use HasFactory;

    protected $table = 'matches';
}
