<?php

use App\Country;
use App\Photo;
use App\Post;
use App\User;
use App\Tag;


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//
//
//    return view('welcome');
//

//});
//
//Route::get('/about', function () {
//
//
//    return "Hi about page";
//
//
//});
//
//Route::get('/contact', function () {
//
//
//    return "Hi contact page";
//
//
//});
//
//Route::get('/post/{id}/{name}', function ($id, $name){
//
//    return "This is post number " . $id . " : " . $name;
//
//
//});
//
//Route::get('/admin/posts/example', array('as'=>'admin.home', function(){
//
//    $url = route('admin.home');
//
//    return "This url is " . $url;
//
//}));*/

// Route::get('post/{id}/{name}', 'PostController@index');

//Route::resource('posts', 'PostController');
//
//Route::get('/contact', 'PostController@contact');
//
//
//Route::get('/post/{id}/{name}/{password}', 'PostController@show_post');



//DATABASE RAW SQL QUERIES

//Route::get('insert', function (){
//
//
//    DB::insert('insert into posts(title, content) values(?, ?)', ['PHP 5', 'PHP laravel is the best thing']);
//
//});



//Route::get('read', function(){
//
//    $result = DB::select('select * from posts where id = ?', [1]);
//
//    return var_dump($result);

//    foreach ($result as $post){
//
//        return $post->title;
//    }


//});

//
//Route::get('update', function (){
//
//    $update = DB::update('update posts set title="Update Title" where id = ?', [1]);
//
//    return $update;
//
//});


//Route::get('delete', function(){
//
//    $delete = DB::delete('delete from posts where id = ?', [1]);
//
//    return $delete;
//
//});


//ELOQUENT OR ORM

//Route::get('read', function (){
//
//    $posts = Post::all();
//
//    foreach ($posts as $post){
//
//        return $post->title;
//
//    }
//
//});

//Route::get('find', function (){
//
//    $posts = Post::find(2);
//
//    return $posts->title;
//
//});


//Route::get('findwhere', function (){
//
//
//    $posts = Post::where('id', 3)->orderBy('id', 'desc')->take(1)->get();
//
//    return $posts;
//
//
//});
//
//Route::get('findmore', function (){


//    $posts = Post::findOrFail(2);
//
//    return $posts;

//
//    $posts = Post::where('users_count', '<', 50)->firstOrFail();
//
//    return $posts;


//});


//Route::get('basicinsert', function (){
//
//
//    $post = new Post;
//
//    $post->title = 'New Eloquent title 6';
//    $post->content = 'Wow Eloquent is really cool. Look at this content';
//    $post->save();
//
//
//
//});


//Route::get('basicinsert2', function (){
//
//    $post = Post::find(2);
//
//    $post->title = 'UPDATE title';
//    $post->content = 'Update content';
//    $post->save();
//});




//Route::get('create', function(){
//
//
//    Post::create(['title' => 'The create method', 'content' => 'Wow im learning new stuff']);
//
//
//});

//
//Route::get('update', function(){
//
//    Post::where('id', 2)->where('is_admin', 0)->update(['title'=> 'NEW PHP TITLE', 'content' => 'New content for update video']);
//
//
//});



//Route::get('delete', function(){
//
//
//    $post = Post::find(2);
//
//    $post->delete();
//
//
//});

//Route::get('delete2', function(){
//
//
//    Post::destroy([4,5]);

//    Post::where('is_admin', 0)->delete();
//
//});


//Route::get('softdelete', function (){
//
//
//    Post::find(1)->delete();
//
//
//});


//Route::get('readsoftdelete', function (){


//    $post = Post::find(1);
//
//    return $post;


//    $post = Post::withTrashed()->where('id', 1)->get();
//
//    return $post;
//
//    $post = Post::onlyTrashed()->get();
//
//    return $post;
//
//});

//Route::get('restore', function(){
//
//
////        Post::onlyTrashed()->restore();
//
//    $post = Post::withTrashed()->where('id', 1)->restore();
//
//    return $post;
//
//});

//Route::get('forcedelete', function(){
//
//    Post::onlyTrashed()->forceDelete();
//
//
//});


//Route::get('postinsert', function(){
//
//    $post = new Post();
//
//    $post->title = "Ny fra Sajid";
//    $post->user_id = 3;
//    $post->content = 'sajid content';
//    $post->save();
//
//    return $post;
//
//
//});
//
//Route::get('userinsert', function (){
//
//    $user = new User();
//
//    $user->name = "Sajid3";
//    $user->email = 'saji3@gmail.com';
//    $user->password = '123';
//    $user->save();
//
//    return $user;
//
//
//
//});

//
//**************  ELOQUENT RELATIONSHIPS*********************


// ***ONE TO ONE RELATIONSHIP*****

//*** TIP **** Du skal huske at gå ind i POST og USER for at lave en connection mellem POST og USER

//Route::get('user/{id}/post', function ($id){
//
//
////    return User::find($id)->post->title;
//    return User::find($id)->post;
//
//
//});

//
//Route::get('post/{id}/user', function ($id){
//
//
//    return Post::find($id)->user->name;
//
//});


// ***ONE TO MANY RELATIONSHIP *****
//Route::get('post/{id}', function($id){
//
//
//    $user = User::find($id);
//
//    foreach ($user->posts as $post ){
//
//        echo $post->title . '<br>';
//    }
//
//});

// *** MANY TO MANY RELATIONSHIP *****
//Route::get('user/{id}/role', function ($id){
//
//    $user = User::find($id);
//
//    foreach ($user->roles as $role) {
//
//        return $role->name;
//    }
//
//});

// *** Accessing intermediate table / Pivot table  *****

//Route::get('user/pivot', function(){
//
//    $user = User::find(1);
//
//    foreach ($user->roles as $role){
//
//        echo $role->pivot->created_at;
//    }
//});
//
//
//
//
//Route::get('user/country', function(){
//
//    $country = Country::find(2);
//
//        foreach($country->posts as $post) {
//
//        return $post->title;
//
//    }
//
//
//});


//**************  Polymorphic  RELATIONSHIPS*********************


//Route::get('post/photos', function (){
//
//
//    $post = Post::find(1);
//
//    foreach ($post->photos as $photo) {
//
//        return $photo;
//
//    }
//
//
//
//});

//Route::get('photo/{id}/post', function ($id){
//
//    $photo = Photo::findOrFail($id);
//
//    $imageable = $photo->imageable;
//
//    return $imageable;
//
//});

// //**************   Polymorphic MANY TO MANY //**************


//Route::get('post/tag', function (){
//
//
//    $post = Post::find(1);
//
//    foreach ($post->tags as $tag){
//
//        echo $tag->name;
//
//    }
//
//
//
//});
//

//Route::get('tag/post', function (){
//
//    $tag = Tag::find(2);
//
//    foreach ($tag->posts as $post)
//    {
//
//        echo $post->title;
//
//    }
//
//
//});


/*
|--------------------------------------------------------------------------
| CRUD application
|--------------------------------------------------------------------------
|
*/



Route::group(['middleware'=>['web']], function(){


    Route::resource('posts', 'PostController');



});



































