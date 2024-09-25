<?php

use Illuminate\Support\Facades\Route;
use backend\CustomerController;
use backend\SupplierController;
use backend\CategoryController;
use backend\BrandController;
use backend\ProductController;
use backend\GroupController;
use backend\UnitController;
use backend\TaxController;
use backend\PurchaseController;
use backend\SellController;
use backend\CustomerGroupCotroller;
use backend\VarientController;
use backend\ExpenseCategoryController;
use backend\ExpenseController;
use backend\DiscountController;
use backend\PackageTypeController;
use backend\PackageController;
use backend\CourierController;
use backend\StockController;
use backend\DamageController;
use backend\ParcelTypeController;
use backend\DeliveryOptionController;
use backend\OrderStatusController;
use backend\CourierPackageController;
use backend\ParcelController; 
use backend\DeliveryController; 
use backend\OnTheWayController;
use backend\RejectedController;
use backend\PurchaseReturnController;
use backend\SellReturnController;
use backend\userRole\UserController;
use backend\userRole\RoleController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [App\Http\Controllers\HomePageController::class, 'index']);

Auth::routes();

//All the backend route list here...
Route::group(['middleware'=>['auth']],function(){

	Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');

	//UserRolePermission System Controller...
	Route::resource('users', UserController::class);
	Route::get('user-active/{id}', [App\Http\Controllers\backend\userRole\UserController::class, 'userActive'])->name('user-active');
    Route::get('user-inactive/{id}', [App\Http\Controllers\backend\userRole\UserController::class, 'userInactive'])->name('user-inactive');
    Route::post('user-password-update/{id}', [App\Http\Controllers\backend\userRole\UserController::class, 'userPassword'])->name('user-password-update');
	Route::resource('roles', RoleController::class);

	//Category, Brand, Group, Unit, Varient Controller...
	Route::resource('category', CategoryController::class);
	Route::get('category-active/{id}', [App\Http\Controllers\backend\CategoryController::class, 'activeDefaultData'])->name('category-active');
	Route::get('category-inactive/{id}', [App\Http\Controllers\backend\CategoryController::class, 'inDefaultActiveData'])->name('category-inactive');

	Route::resource('brand', BrandController::class);
	Route::get('brand-active/{id}', [App\Http\Controllers\backend\BrandController::class, 'activeDefaultData'])->name('brand-active');
	Route::get('brand-inactive/{id}', [App\Http\Controllers\backend\BrandController::class, 'inDefaultActiveData'])->name('brand-inactive');


	Route::resource('group', GroupController::class);
	Route::get('group-active/{id}', [App\Http\Controllers\backend\GroupController::class, 'activeDefaultData'])->name('group-active');
	Route::get('group-inactive/{id}', [App\Http\Controllers\backend\GroupController::class, 'inDefaultActiveData'])->name('group-inactive');


	Route::resource('unit', UnitController::class);
	Route::get('unit-active/{id}', [App\Http\Controllers\backend\UnitController::class, 'activeDefaultData'])->name('unit-active');
	Route::get('unit-inactive/{id}', [App\Http\Controllers\backend\UnitController::class, 'inDefaultActiveData'])->name('unit-inactive');

	Route::resource('varient', VarientController::class);

	//Tax System Controller...
	Route::resource('tax', TaxController::class);
	Route::get('tax-active/{id}', [App\Http\Controllers\backend\TaxController::class, 'activeDefaultData'])->name('tax-active');
	Route::get('tax-inactive/{id}', [App\Http\Controllers\backend\TaxController::class, 'inDefaultActiveData'])->name('tax-inactive');


    //Discount System Controller...
	Route::resource('discount', DiscountController::class);
	Route::get('discount-active/{id}', [App\Http\Controllers\backend\DiscountController::class, 'activeDefaultData'])->name('discount-active');
	Route::get('discount-inactive/{id}', [App\Http\Controllers\backend\DiscountController::class, 'inDefaultActiveData'])->name('discount-inactive');

	//Product Controller...
	Route::resource('product', ProductController::class);
	Route::get('product-active/{id}', [App\Http\Controllers\backend\ProductController::class, 'productActive'])->name('product-active');
    Route::get('product-inactive/{id}', [App\Http\Controllers\backend\ProductController::class, 'productInactive'])->name('product-inactive');
	Route::post('/product-search', [App\Http\Controllers\backend\ProductController::class, 'search'])->name('product.search');
	Route::get('details/{id}', [App\Http\Controllers\backend\ProductController::class, 'details'])->name('details');

	Route::resource('expense-category', ExpenseCategoryController::class);
	Route::resource('expense', ExpenseController::class);

	//Customer & Supplier Controller...
	Route::resource('customer-group', CustomerGroupCotroller::class);
	Route::resource('customers', CustomerController::class);
	Route::post('/customer-search', [App\Http\Controllers\backend\CustomerController::class, 'search'])->name('customer.search');


	Route::resource('supplier', SupplierController::class);
	Route::post('/supplier-search', [App\Http\Controllers\backend\SupplierController::class, 'search'])->name('supplier.search');
	Route::get('/supplier-profile/{id}', [App\Http\Controllers\backend\SupplierController::class, 'getSupplierProfile'])->name('supplier.profile');


	
	//Package Controller...
	Route::resource('packageType', PackageTypeController::class);
	Route::resource('package', PackageController::class);

	//Purchase Stock System Controller...
	Route::resource('stock', StockController::class);
	Route::get('stock-alert', [App\Http\Controllers\backend\StockController::class, 'stockAlert'])->name('stockAlert');

	Route::resource('damage', DamageController::class);
	Route::get('get-batch-product-wise/{id}', [App\Http\Controllers\backend\DamageController::class, 'getBatchProductWise'])->name('get-batch-product-wise');


	Route::resource('purchase-return', PurchaseReturnController::class);
	Route::post('purchase-return-product-list', [App\Http\Controllers\backend\PurchaseReturnController::class, 'purchaseReturnProductList'])->name('purchaseReturn.product-list');
	Route::post('purchase-return-submit', [App\Http\Controllers\backend\PurchaseReturnController::class, 'purchaseReturnSubmit'])->name('purchaseReturn.submit');


	Route::resource('sell-return', SellReturnController::class);
	Route::post('sell-return-product-list', [App\Http\Controllers\backend\SellReturnController::class, 'sellReturnProductList'])->name('sellReturn.product-list');
	Route::post('sell-return-submit', [App\Http\Controllers\backend\SellReturnController::class, 'sellReturnSubmit'])->name('sellReturn.submit');
	Route::post('sell-damage-submit', [App\Http\Controllers\backend\SellReturnController::class, 'sellDamageSubmit'])->name('sellDamage.submit');

	Route::resource('purchase', PurchaseController::class);
	Route::get('purchase-due', [App\Http\Controllers\backend\PurchaseController::class, 'purchaseDue'])->name('purchase.due');
	Route::post('purchase-product-list', [App\Http\Controllers\backend\PurchaseController::class, 'purchaseProductList'])->name('purchase.product-list');
	Route::post('purchase-update-product-data', [App\Http\Controllers\backend\PurchaseController::class, 'purchaseProductUpdate'])->name('purchase.update-purchase-product-data');
	Route::post('add-purchase-batch', [App\Http\Controllers\backend\PurchaseController::class, 'addPurchaseBatch'])->name('purchase.add-purchase-batch');
	Route::post('set-purchase-product-details', [App\Http\Controllers\backend\PurchaseController::class, 'setPurchaseProductDetails'])->name('purchase.set-purchase-product-details');
	Route::post('add-purchase-product-details', [App\Http\Controllers\backend\PurchaseController::class, 'addPurchaseProductDetails'])->name('purchase.add-purchase-product-details');
	Route::post('update-purchase-product-details', [App\Http\Controllers\backend\PurchaseController::class, 'updatePurchaseProductDetails'])->name('purchase.update-purchase-product-details');
	Route::post('purchase-product-remove', [App\Http\Controllers\backend\PurchaseController::class, 'purchaseProductRemove'])->name('purchase.remove-product');
	Route::post('single-purchase-product-data', [App\Http\Controllers\backend\PurchaseController::class, 'singlePurchaseProductData'])->name('single-purchase-product-data');

	Route::post('add-supplier', [App\Http\Controllers\backend\PurchaseController::class, 'addNewSupplier'])->name('purchase.add-new-supplier');

	Route::post('get-current-purchase-batch-data', [App\Http\Controllers\backend\PurchaseController::class, 'getCurrentBatchData'])->name('get.current-purchase-batch-data');
	
	/*Route::get('purchase-test', [App\Http\Controllers\backend\PurchaseController::class, 'testCreate'])->name('purchase.test');*/
	Route::post('add-product-deatils', [App\Http\Controllers\backend\PurchaseController::class, 'addProductDetails'])->name('add.product-deatils');
	Route::post('filter-products-list', [App\Http\Controllers\backend\PurchaseController::class, 'filterProductList'])->name('filter.product-list');
	Route::post('search-products-list', [App\Http\Controllers\backend\PurchaseController::class, 'searchProductList'])->name('search.product-list');
	Route::get('reset-products-list', [App\Http\Controllers\backend\PurchaseController::class, 'resetProductList'])->name('reset.product-list');
	Route::post('get-purchase-deatils', [App\Http\Controllers\backend\PurchaseController::class, 'getPurchaseDetails'])->name('get.purchase-deatils');
	Route::post('update-product-deatils', [App\Http\Controllers\backend\PurchaseController::class, 'updateProductDetails'])->name('update.product-deatils');
	Route::post('purchaseList-product-remove', [App\Http\Controllers\backend\PurchaseController::class, 'purchaseListProductRemove'])->name('purchaseList.remove-product');
	Route::post('add-purchase-product-batch', [App\Http\Controllers\backend\PurchaseController::class, 'addPurchaseProductBatch'])->name('purchase.add-purchase-product-batch');
	Route::post('get-purchase-product-batch', [App\Http\Controllers\backend\PurchaseController::class, 'getPurchaseProductBatch'])->name('purchase.get-purchase-product-batch');
	Route::post('update-purchase-product-batch', [App\Http\Controllers\backend\PurchaseController::class, 'updatePurchaseProductBatch'])->name('purchase.update-purchase-product-batch');

	Route::post('purchase-table-supplier-add', [App\Http\Controllers\backend\PurchasePaymentController::class, 'purchaseTableCustomerAdd'])->name('purchase-table-supplier-add');

	//Purchase-Payment Controller...
	Route::post('purchase-payment', [App\Http\Controllers\backend\PurchasePaymentController::class, 'purchasePayment'])->name('purchase-payment');
	//Purchase-Due Payment Controller...
	Route::post('purchase-due-payment', [App\Http\Controllers\backend\PurchasePaymentController::class, 'purchaseDuePayment'])->name('purchase-due-payment');

	Route::get('/purchase-invoice/{id}', [App\Http\Controllers\backend\PurchasePaymentController::class, 'purchaseInvoice'])->name('purchase-invoice');
	Route::get('/purchase-due-invoice/{id}', [App\Http\Controllers\backend\PurchasePaymentController::class, 'purchaseDueInvoice'])->name('purchase-due-invoice');
	Route::get('purchase-pdf-download/{id}', [App\Http\Controllers\backend\PurchasePaymentController::class, 'pdfDownload'])->name('purchase-pdf-download');
	Route::get('purchase-print-preview/{purchaseId}', [App\Http\Controllers\backend\PurchasePaymentController::class, 'purchasePrintPreview'])->name('purchase-print-preview');

	//Pagination purchase Product Data...
	Route::post('purchase/next-page-product-data', [App\Http\Controllers\backend\PurchaseController::class, 'nextPageProductData'])->name('purchase.next-page-product-data');
	Route::post('purchase/previous-page-product-data', [App\Http\Controllers\backend\PurchaseController::class, 'previousPageProductData'])->name('purchase.previous-page-product-data');

	//Sell Controller...
	Route::resource('sell', SellController::class);
	Route::get('sell-due', [App\Http\Controllers\backend\SellController::class, 'sellDue'])->name('sell.due');
	Route::post('add-customer', [App\Http\Controllers\backend\SellController::class, 'addNewCustomer'])->name('sell.add-new-customer');
	Route::post('check-cstomer-type', [App\Http\Controllers\backend\SellController::class, 'checkCustomerType'])->name('sell.check-cstomer-type');
	Route::post('sell-product-list', [App\Http\Controllers\backend\SellController::class, 'sellProductList'])->name('sell.product-list');
	Route::post('sell-product-remove', [App\Http\Controllers\backend\SellController::class, 'sellProductRemove'])->name('sell.remove-product');

	Route::post('add-sell-product-deatils', [App\Http\Controllers\backend\SellController::class, 'addSellProductDetails'])->name('add.sell.product-deatils');;
	Route::post('sellList-product-remove', [App\Http\Controllers\backend\SellController::class, 'sellListProductRemove'])->name('sellList.remove-product');

	Route::post('increment-sell-product', [App\Http\Controllers\backend\SellController::class, 'incrementSellProduct'])->name('increment.sell-product');
	Route::post('decrement-sell-product', [App\Http\Controllers\backend\SellController::class, 'decrementSellProduct'])->name('decrement.sell-product');
	Route::post('add-sell-product-qty', [App\Http\Controllers\backend\SellController::class, 'updateSellProductQty'])->name('add-product-qty.sell-product');

	Route::get('/get_customer/{customer_group_id}', [App\Http\Controllers\backend\SellController::class, 'get_customer'])->name('customer.get');

	Route::post('sell-filter-products-list', [App\Http\Controllers\backend\SellController::class, 'filterProductList'])->name('sell.filter.product-list');
	Route::post('sell-search-products-list', [App\Http\Controllers\backend\SellController::class, 'searchProductList'])->name('sell.search.product-list');
	Route::get('sell-reset-products-list', [App\Http\Controllers\backend\SellController::class, 'resetProductList'])->name('sell.reset.product-list');

	Route::post('sell-table-customer-add', [App\Http\Controllers\backend\SellPaymentController::class, 'sellTableCustomerAdd'])->name('sell-table-customer-add');

	//Sell-Payment Controller...
	Route::post('sell-payment', [App\Http\Controllers\backend\SellPaymentController::class, 'sellPayment'])->name('sell-payment');
	Route::get('sell-print-preview/{sellingId}', [App\Http\Controllers\backend\SellPaymentController::class, 'sellPrintPreview'])->name('sell-print-preview');

	//Sell-Payment Controller...
	Route::post('sell-due-payment', [App\Http\Controllers\backend\SellPaymentController::class, 'sellDuePayment'])->name('sell-due-payment');

	Route::get('/selling-invoice/{id}', [App\Http\Controllers\backend\SellPaymentController::class, 'sellInvoice'])->name('selling-invoice');
	Route::get('/selling-due-invoice/{id}', [App\Http\Controllers\backend\SellPaymentController::class, 'sellDueInvoice'])->name('selling-due-invoice');

	//Pagination Sell Product Data...
	Route::post('sell/next-page-product-data', [App\Http\Controllers\backend\SellController::class, 'nextPageProductData'])->name('sell.next-page-product-data');
	Route::post('sell/previous-page-product-data', [App\Http\Controllers\backend\SellController::class, 'previousPageProductData'])->name('sell.previous-page-product-data');


	//Company Invoice Profile Controller...
	Route::get('/companyInvoiceProfile', [App\Http\Controllers\backend\CompanyInvoiceProfileController::class, 'index'])->name('companyInvoiceProfile');
	Route::post('/companyInvoiceProfile-update/{id}', [App\Http\Controllers\backend\CompanyInvoiceProfileController::class, 'update'])->name('companyInvoiceProfile.update');

	//To Profile Update...
	Route::get('/profile', [App\Http\Controllers\backend\profileController::class, 'index'])->name('profile');
	Route::post('/profile/update', [App\Http\Controllers\backend\profileController::class, 'update'])->name('profile.update');
	Route::get('/security', [App\Http\Controllers\backend\profileController::class, 'security'])->name('security');
	Route::post('/profile/security/update', [App\Http\Controllers\backend\profileController::class, 'securityUpdate'])->name('profile.security.update');
	
	Route::get('/setting', [App\Http\Controllers\backend\settingController::class, 'index'])->name('setting');
	Route::post('/setting-update/{id}', [App\Http\Controllers\backend\settingController::class, 'update'])->name('setting.update');
	

	//Courier Controller...
	Route::resource('courier', CourierController::class);
	Route::resource('courierPackage', CourierPackageController::class);
	
	Route::resource('percels', ParcelController::class);
	Route::get('/parcel-details/{id}', [App\Http\Controllers\backend\ParcelController::class, 'parcelDetails'])->name('parcel.detail');
	Route::post('/parcel-details', [App\Http\Controllers\backend\ParcelController::class, 'addParcelDetails'])->name('parcel.details');
	
	Route::resource('percel-type', ParcelTypeController::class);
	Route::resource('delivery-option', DeliveryOptionController::class);
	Route::resource('order-status', OrderStatusController::class);
	
	Route::resource('delivered', DeliveryController::class);
	Route::resource('rejected', RejectedController::class);
	Route::get('/rejected/add-in-stock/{id}', [App\Http\Controllers\backend\RejectedController::class, 'addInStock'])->name('rejected.add-in-stock');
	Route::post('/rejected/add-in-damage', [App\Http\Controllers\backend\RejectedController::class, 'addInDamage'])->name('rejected.add-in-damage');
	Route::resource('onTheWay', OnTheWayController::class);


	//All the report route list...

	//purchase report route .......
	Route::get('/purchase-todays-report', [App\Http\Controllers\backend\report\PurchaseReportController::class, 'purchaseTodaysReport'])->name('purchase-todays-report');
	Route::get('/purchase-weekend-report', [App\Http\Controllers\backend\report\PurchaseReportController::class, 'currentWeekendReport'])->name('purchase-weekend-report');
	Route::get('/purchase-month-report', [App\Http\Controllers\backend\report\PurchaseReportController::class, 'currentMonthReport'])->name('purchase-month-report');

	Route::get('/purchase-daily-report-with-date', [App\Http\Controllers\backend\report\PurchaseReportController::class, 'dailyReport'])->name('purchase-daily-report-with-date');
	Route::post('/purchase-daily-report-with-date', [App\Http\Controllers\backend\report\PurchaseReportController::class, 'dailyReportWithDate'])->name('purchase-daily-report-with-date');

	Route::get('/purchase-monthly-report-with-month-name', [App\Http\Controllers\backend\report\PurchaseReportController::class, 'monthlyReport'])->name('purchase-monthly-report-with-month-name');
	Route::post('/purchase-monthly-report-with-month-name', [App\Http\Controllers\backend\report\PurchaseReportController::class, 'monthlyReportWithMonthName'])->name('purchase-monthly-report-with-month-name');

	Route::get('/purchase-report-with-between-date', [App\Http\Controllers\backend\report\PurchaseReportController::class, 'reportWithBetweenDates'])->name('purchase-report-with-between-date');
	Route::post('/purchase-report-with-between-date', [App\Http\Controllers\backend\report\PurchaseReportController::class, 'reportWithBetweenTwoDates'])->name('purchase-report-with-between-date');



	//sell report route .......
	Route::get('/sale-todays-report', [App\Http\Controllers\backend\report\SellReportController::class, 'sellTodaysReport'])->name('sale-todays-report');
	Route::get('/sale-weekend-report', [App\Http\Controllers\backend\report\SellReportController::class, 'currentWeekendReport'])->name('sale-weekend-report');
	Route::get('/sale-month-report', [App\Http\Controllers\backend\report\SellReportController::class, 'currentMonthReport'])->name('sale-month-report');
	Route::get('/sale-daily-report-with-date', [App\Http\Controllers\backend\report\SellReportController::class, 'dailyReport'])->name('sale-daily-report-with-date');
	Route::post('/sale-daily-report-with-date', [App\Http\Controllers\backend\report\SellReportController::class, 'dailyReportWithDate'])->name('sale-daily-report-with-date');
	Route::get('/sale-monthly-report-with-month-name', [App\Http\Controllers\backend\report\SellReportController::class, 'monthlyReport'])->name('sale-monthly-report-with-month-name');
	Route::post('/sale-monthly-report-with-month-name', [App\Http\Controllers\backend\report\SellReportController::class, 'monthlyReportWithMonthName'])->name('sale-monthly-report-with-month-name');

	Route::get('/sale-report-with-between-date', [App\Http\Controllers\backend\report\SellReportController::class, 'reportWithBetweenDates'])->name('sale-report-with-between-date');
	Route::post('/sale-report-with-between-date', [App\Http\Controllers\backend\report\SellReportController::class, 'reportWithBetweenTwoDates'])->name('sale-report-with-between-date');


	Route::get('/stock-alert-report', [App\Http\Controllers\backend\report\SellReportController::class, 'stockAlertReport'])->name('stock-alert-report');
	Route::post('/stock-alert-report', [App\Http\Controllers\backend\report\SellReportController::class, 'stockAlertReportSearch'])->name('stock-alert-report-search');

	Route::post('/search-product-details', [App\Http\Controllers\backend\ProductController::class, 'searchProductDetails'])->name('search.productDetails');
	
});