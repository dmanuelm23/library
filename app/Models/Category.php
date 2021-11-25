<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    
    // Possible status
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
   
    protected $table = 'categories';
    
    protected $fillable=[
            'name',
            'description',
            'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden =['created_at', 'updates_at'];

    public function books(){
        return $this->belongsToMany(Book::class);
    }

    /**
    * Toggles status
    * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
    * @create 24/11/2021
    */
    public function toggleStatus()
    {
        $this->status = $this->status ? self::STATUS_INACTIVE : self::STATUS_ACTIVE;
        $this->save();
    }
}
