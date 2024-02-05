<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];
    // protected $fillable = [
    //     'title',
    //     'created_at',
    //     'updated_at',
    //     'deleted_at',
    // ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
