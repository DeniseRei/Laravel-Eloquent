<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

/*
|--------------------------------------------------------------------------
| Select Function
|--------------------------------------------------------------------------
|
*/
Route::get('/select', function(){
    //$users = User::all();
    //$users = User::where('id', 10)->get();
    //$users = User::first();
    //$users = User::find(10);
    //$users = User::findOrFail(10);
    //$users = User::where('name', request('name'))->firstOrFail();
    $users = User::firstWhere('name', request('name'));
    dd($users);
});
/*
|--------------------------------------------------------------------------
| Where Function
|--------------------------------------------------------------------------
|
*/
Route::get('/where', function(User $user){
   $users = $user->get(); //trouxe a collection, todos os users
   //$users = $user->where('email', '=', 'therese.buckridge@example.org')->first();
   //$users = $user->where('email','therese.buckridge@example.org')->first(); //não precisa passar o '='
   $filter = 'd';
  // $users = $user->where('name', 'LIKE', "%{$filter}%")
              //  ->orWhere('name', 'Gabriel')
               // ->get(); //%$filter que contenha 'ab' no inicio, $filter% contenha no final,%$filter%, contenha na palavra
/*     $users = $user->where('name', 'LIKE', "%{$filter}%")
                    ->whereName('Gabriel') //->whereNot(), ->whereDate(), ->whereIn('email', []), orWherein()
                    ->get(); */
    /* $users = $user->where('name', 'LIKE', "%{$filter}%")
                  ->orWhere(function($query) use ($filter){
                        $query->where('name', '<>', 'Denise');
                        $query->where('name', '=', $filter);
                  })
                  ->toSql(); */

                dd($users);

});
/*
|--------------------------------------------------------------------------
| Paginate Function
|--------------------------------------------------------------------------
|
*/
Route::get('/pagination', function () {
    //$users = User::paginate(10);
        //frontend = {{ $users->links() }}
        //$users = User::where('name', 'LIKE', "%a%")->paginate();
    //return $users;

    //para API
    $filter = request('filter');
    $totalPage = request('paginate', 10);
    $users = User::where('name', 'LIKE', "%{$filter}%")->paginate($totalPage);
    //URL = http://localhost:8180/pagination?page=1&filter=a
    //URL  http://localhost:8180/pagination?page=1&filter=a&paginate=20

    return $users;
});
/*
|--------------------------------------------------------------------------
| Orderby Function
|--------------------------------------------------------------------------
|
*/
Route::get('/orderby', function (User $user) {

    //$users = $user->orderBy('name')->get();
    $users = $user->orderBy('id', 'DESC')->get();

    //dd($users);

    return $users;
});
/*
|--------------------------------------------------------------------------
| Insert Function
|--------------------------------------------------------------------------
|
*/
Route::get('/insert', function (Post $post, Request $request) {

    /*Inserir na "mão"*/

    $post->user_id = 1;
    //$post->title = 'Primeiro Post ' .  Str::random(10);
    $post->title = $request->name; /*API*///Utiliza o request
    $post->body = 'Conteúdo do Post';
    $post->date = date('Y-m-d');
    $post->save();


    /*Retorno todos os posts*/
    $posts = $post->get();

    return $posts;
});
/*
|--------------------------------------------------------------------------
| Insert advanced Function
|--------------------------------------------------------------------------
|

*/
/* Route::get('/insert2', function(){
    $post = Post::create([
        'user_id' => 1,
        'title' => 'Valor name',
        'body' => 'Valor body',
        'date' => date('Y-m-d'),
    ]);

    $posts = Post::get();

    return $posts;
}); */

/*API request*/
Route::get('/insert2', function(Request $request){
    $post = Post::create($request->all());
    dd($post);
    $posts = Post::get();

    return $posts;
});

/*
|--------------------------------------------------------------------------
| Welcome Function
|--------------------------------------------------------------------------
|
*/
Route::get('/', function () {
    return view('welcome');
});
