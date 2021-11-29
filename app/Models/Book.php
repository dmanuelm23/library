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

    /**
    * Relationship: One category can have many books assigned
    * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
    * @created 25/11/2021
    * @params 
    * @return  \Illuminate\Database\Eloquent\Relations\hasToMany
    */
    public function categories(){
        return $this->hasToMany(Category::class);
    }

    /**
    * Relationship: Many to Many Books and Users
    * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
    * @created 25/11/2021
    * @params 
    * @return  \Illuminate\Database\Eloquent\Relations\belongsToMany
    */
    public function booksUsers(){
        return $this->belongsToMany(User::class,'loan_books','book_id','user_id');
    }
    
    /**
    * Toggles status
    * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
    * @create 25/11/2021
    */
    public function toggleStatus()
    {
        $this->status = $this->status ? self::STATUS_INACTIVE : self::STATUS_ACTIVE;
        $this->save();
    }
}
