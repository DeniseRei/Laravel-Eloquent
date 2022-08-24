<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
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


Route::get('/', function () {
    return view('welcome');
});
