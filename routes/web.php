<?php

use App\Models\Post;
use App\Models\User;
use App\Scopes\YearScope;
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

Route::get('/select', function () {
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

Route::get('/where', function (User $user) {
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
    $post->title = $request->name; /*API*/ //Utiliza o request
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
Route::get('/insert2', function (Request $request) {
    $post = Post::create($request->all());
    dd($post);
    $posts = Post::get();

    return $posts;
});

/*
|--------------------------------------------------------------------------
| Update Function
    //verbo http put/path, estou utilizando get para estudo
|--------------------------------------------------------------------------
|
*/

Route::get('/update', function () {
    /*1° Recuperar registro atraves de um identificador unico e verificar se ele existe*/
    if (!$post = Post::find(1))
        return 'Post not found';
    /*2° alterando valores*/
    $post->user_id = 1;
    $post->title = 'Valor title atualizado';
    $post->body = 'Valor body update';
    $post->date = date('Y-m-d');
    /*3° salvando valores alterados*/
    $post->save();
    /*4° exibindo registro alterado*/
    dd(Post::find(1));
});

/*
|--------------------------------------------------------------------------
| Update Function API Request
    //verbo http put/path, estou utilizando get para estudo
    //o metodo update() só funciona porque existe a fillable no Model.
    //URL: http://localhost:8180/update2?title=update2
|--------------------------------------------------------------------------
|
*/

Route::get('/update2', function (Request $request) {
    if (!$post = Post::find(1))
        return 'Post not found';

    $post->update($request->all());

    dd(Post::find(1));
    //URL: http://localhost:8180/update2?title=update2
});

/*
|--------------------------------------------------------------------------
| Delete Function
|--------------------------------------------------------------------------
|
*/

Route::get('/delete', function () {
    /*Encontrar o registro que eu quero deletar*/

    if (!$post = Post::find(4))
        return "Post not found";

    $post->delete();

    $posts = Post::all();

    return $posts;

    /*Destroy*/
    /*Post::destroy(Post::get()) = dentro do metodo eu passo um parametro, um array,
    tem mais possibilidades que o delete()*/
});

/*
|--------------------------------------------------------------------------
| Delete Function 2
|--------------------------------------------------------------------------
|
*/

Route::get('/delete2', function () {

    if (!$post = Post::destroy(5))
        return "Post not found";

    $posts = Post::get();

    return $posts;
});

/*
|--------------------------------------------------------------------------
| Accessor Function
|--------------------------------------------------------------------------
|
*/

Route::get('/accessor', function () {
    $post = Post::first();

    return $post;
    //return $post->date;
});

/*
|--------------------------------------------------------------------------
| Mutators Function
|--------------------------------------------------------------------------
|
*/

Route::get('/mutators', function () {

    $user = User::first();
    $post = Post::create([
        'user_id' => $user->id,
        'title' => 'Um novo titulo' . Str::random(10),
        'body' => Str::random(100),
        'date' => now(),
    ]);

    //$posts = Post::get();

    return $post;
});

/*
|--------------------------------------------------------------------------
| Local Scope Function
|--------------------------------------------------------------------------
|
*/

Route::get('/local-scope', function () {
    //$posts = Post::lastWeek()->get();
    /* $posts = Post::today()->get(); */
    $posts = Post::between('2022-01-01', '2022-12-31')->get();
    return $posts;
});

/*
|--------------------------------------------------------------------------
| Anonymous Scope Function
|--------------------------------------------------------------------------
|
*/

Route::get('/anonymous-global-scopes', function(){
    //$posts = Post::get();

    /*Se não quiser utilizar o scope global*/
    $posts = Post::withoutGlobalScope('year')->get();

    return $posts;
});

/*
|--------------------------------------------------------------------------
| Global Scope Function
|--------------------------------------------------------------------------
|
*/
 Route::get('/global-scope', function(){
    //$posts = Post::get();
    $posts = Post::withoutGlobalScope(YearScope::class)->get();

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
