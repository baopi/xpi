<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use BaseTrait;

    const STATUS_FIELD = 'status';
    const VALID_STATUS = 1;
}