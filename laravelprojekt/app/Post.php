<?php

namespace App;

use Illuminate\Database\Eloquent\Model; // Sajids notes: this you use to access this Post Model.
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model // Sajids notes: laravel thinks there is a post table called: posts with s at the end.
{

    // TABLE NAME info
// My notes: if this model was called PostAdmin, then Laravel would assume that a table is referenced as "postadmins" with
// a s. But you can make a function called
// "protected $table = 'posts';

// PRIMARY KEY ID info
// Laravel assume that the primary key is "id". If not, corrected it by writing exampel "post_id"

    use SoftDeletes;



    protected $dates = ['deleted_at'];


// protected $primaryKey = 'post_id';

    protected $fillable = [ //Sajid notes: we can now insert new data with $fillable protected key, which has been modifed.


    'title',
    'content'

];
    protected function user(){

        return $this->belongsTo('App\User');

    }

    public function photos(){

        return $this->morphMany('App\Photo', 'imageable');


    }

    public function tags(){

        return $this->morphToMany('App\Tag', 'taggable');

    }


}
