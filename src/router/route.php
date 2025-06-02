<?

use controller\Auth;
use controller\Catalog;
use controller\Adm;
use controller\Basket;
use controller\Product;
use controller\Profile;
use utils\Route;
use controller\Usl;
use controller\Constr;


Route::Get('/', 'home');
Route::Get('/registration', 'registration');
Route::Get('/categories', 'categories');
Route::Get('/catalog', 'catalog');
Route::Get('/product', 'product');
Route::Get('/basket', 'basket');
Route::Get('/profile', 'profile');
Route::Get('/adm', 'adm');
Route::Get('/admprod', 'admprod');
Route::Get('/admorders', 'admorders');
Route::Get('/usl', 'usl');
Route::Get('/404', '404');
Route::Get('/forgot', 'forgot');
Route::Get('/reset', 'reset');
Route::Get('/palitic', 'palitic');
Route::Get('/reviews', 'reviews');
Route::Get('/records', 'records');
Route::Get('/admrecords', 'admrecords');
Route::Get('/admconstr', 'admconstr');


Route::Post('/registration_form', Auth::class, 'regUser');
Route::Post('/login_form', Auth::class, 'authUser');
Route::Post('/logout_form', Auth::class, 'logout');
Route::Post('/send_recovery_code', Auth::class, 'sendRecoveryCode');
Route::Post('/reset_password_form', Auth::class, 'resetPassword');


Route::Post('/add_form', Adm::class, 'addProductWithVariants');
Route::Post('/update_form', Adm::class, 'updateProductWithVariants');
Route::Post('/update_img', Adm::class, 'updateProductImages');
Route::Post('/update_video_form', Adm::class, 'updateVideo');
Route::Post('/dell_form', Adm::class, 'dell');
Route::Post('/statusOrder_form', Adm::class, 'statusOrder');
Route::Post('/statusRecord_form', Adm::class, 'statusRecords');


Route::Post('/addToCart_form', Basket::class, 'Basket');
Route::Post('/add_tovar_form', Basket::class, 'addTovar');
Route::Post('/remove_tovar_form', Basket::class, 'removeTovar');
Route::Post('/dell_pozition_form', Basket::class, 'dellPozit');
Route::Post('/addOrder_form', Basket::class, 'addOrder');


Route::Post('/filterProducts_form', Catalog::class, 'getFilteredProducts');





Route::Post('/reviewForm', Profile::class, 'review');


Route::Post('/modalForm', Usl::class, 'addRecords');

Route::Post('/addHomeVideo_form', Constr::class, 'addVideo');
Route::Post('/upServises_form', Constr::class, 'addSrvises');
Route::Post('/addTopMaterials', Constr::class, 'addTopMaterials');
Route::Post('/addTopColors', Constr::class, 'addTopColors');
Route::Post('/addMaterials', Constr::class, 'addMaterials');
Route::Post('/addColors', Constr::class, 'addColors');
Route::Post('/deleteTop', Constr::class, 'delTop');
Route::Post('/deleteTopCol', Constr::class, 'delTopCol');
Route::Post('/deleteCol', Constr::class, 'delCol');
Route::Post('/addCarBrands_form', Constr::class, 'addCarBrands');
Route::Post('/dellCarBrands_form', Constr::class, 'dellCarBrands');
Route::Post('/addCarModel_form', Constr::class, 'addCarModel');
Route::Post('/dellCarModels_form', Constr::class, 'dellcarModels');




Route::Contens();
