<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
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
   
    protected $table = 'books';
    
    protected $fillable=[
            'name',
            'author',
            'publication_date',
            'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden =['created_at', 'updates_at'];

    public function categories(){
        return $this->hasToMany(Category::class);
    }

    public function booksUsers(){
        return $this->belongsToMany(User::class,'loan_books','book_id','user_id');
    }

    public function toggleStatus()
    {
        $this->status = $this->status ? self::STATUS_INACTIVE : self::STATUS_ACTIVE;
        $this->save();
    }
}
