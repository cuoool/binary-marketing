<?php
/***
 * Back-end
 */
Route::group(['prefix' => 'admin', 'middleware' => 'admin.auth:admin'],function(){
	Route::get('/', function(){
		return view('admin.index');
	});
});

Route::group(['prefix' => 'admin'], function(){
	Route::get('login', 'Admin\Auth\LoginController@loginForm');
	Route::post('login', 'Admin\Auth\LoginController@login');
	Route::get('logout', 'Admin\Auth\LoginController@logout');
});



/***
 * Front-end
 */
Auth::routes();

Route::group(['middleware' => 'auth'], function(){
	Route::get('/account',  'UserController@index');
	Route::get('/logout', 'Auth\LoginController@logout');

	Route::get('/user/getProfile', 'Api\UserController@getProfile');

	//Deposit
	Route::get('/deposit', 'DepositController@showForm')->name('deposit');
	Route::post('/deposit', 'DepositController@create');	
});


Route::get('/customer/activation/{token}', 'Auth\RegisterController@confirm');

Route::get('/getCountry', 'CountryController@get');

Route::get('/', 'HomeController@index');

Route::get('/home', function(){
	return redirect()->to('/');
});

Route::get('/about-us', function(){
	$data = \App\CompanyProfile::where('field', 'about-us')->first();

	return view('about-us', compact('data'));
});

Route::get('/contact-us', 'ContactController@index');

Route::get('/term', function(){
	return view('term');
});

Route::get('/plan', function(){
	return view('plan');
});

Route::get('/faq', 'FaqController@get');

Route::get('/what-is-forex', function(){
	$data = \App\CompanyProfile::where('field', 'what-is-forex')->first();
	return view('what-is-forex', compact('data'));
});


Route::get('/service/{slug}', 'ServiceController@get');

// Customer send mail
Route::post('/customer/message', 'UserController@sendMessage');

Route::get('/payment/crypto', 'PaymentController@index');
Route::get('/payment/crypto/callback', 'PaymentController@callBack');
Route::post('/payment/crypto/callback', 'PaymentController@callBack');


Route::get('/payment', function(){
		return \App\Customer::with('deposits.crypto_payment')
							//->where('id', auth()->user()->id)
							->get();
	});