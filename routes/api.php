<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// -Pesquisa de veículos, sendo possível realizar filtros semelhantes ao do site. Deverá ser retornado as informações básicas dos veículos (ano, modelo, quilometragem e valor) 
// Example: search?type=car&condition=seminovo&brand=Chevrolet&model=1367&value1=2000&value2=16000&year1=1990&year2=2019&city=2700&user=todos
//  # /carro/estado-conservacao/seminovo/marca/Chevrolet/modelo/1367/valor1/2000/valor2/16000/ano1/1933/ano2/2020/cidade/2700/usuario/todos
Route::get('/search',
'SearchController@search');


// -Detalhes do veículo, retornando detalhadamente todos os dados de um veículo (Ano, quilometragem, tipo de combustível, cor, acessórios e observações) 
// Example: /detail/chevrolet/vectra-sedan/2003-2003/2470937
Route::get('/detail/{manufacturer}/{model}/{year}/{id}', 'DetailController@detail');


