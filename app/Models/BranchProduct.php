<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchProduct extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['stock'];

    public function getTable(): string
    {
        return 'branch_product';
    }
}
