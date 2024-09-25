<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;

Route::group(['namespace' => 'API'], function () {

    //Auth Controller register login
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
    Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('update-password');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    //To verify otp...
    Route::post('otp-verify-code', [AuthController::class, 'verifyOtp'])->name('otp-verify-code');
    Route::post('resend-otp', [AuthController::class, 'resendOtp'])->name('resend-otp');

    Route::group(['middleware' => 'auth:api'], function () {


        //purchase api route ...............
        Route::apiResource('purchase', PurchaseController::class);
        Route::get('/purchaseGetAllDetails', [App\Http\Controllers\API\PurchaseController::class, 'purchaseGetAllDetails'])->name('purchaseGetAllDetails');

        Route::get('/getBatchProductIdWise/{id}', [App\Http\Controllers\API\PurchaseController::class, 'getBatchProductIdWise'])->name('getBatchProductIdWise');
        Route::Post('/addNewPurchaseProductBatch', [App\Http\Controllers\API\PurchaseController::class, 'addNewPurchaseProductBatch'])->name('addNewPurchaseProductBatch');
        Route::Post('/updatePurchaseProductBatch/{id}', [App\Http\Controllers\API\PurchaseController::class, 'updatePurchaseProductBatch'])->name('updatePurchaseProductBatch');

        Route::Post('/addPurchaseProductDeatils', [App\Http\Controllers\API\PurchaseController::class, 'addPurchaseProductDeatils'])->name('addPurchaseProductDeatils');

        Route::post('purchaseProductRemove', [App\Http\Controllers\API\PurchaseController::class, 'purchaseProductRemove'])->name('purchaseProductRemove');

        Route::Post('/updatePurchaseProductDeatils', [App\Http\Controllers\API\PurchaseController::class, 'updatePurchaseProductDeatils'])->name('updatePurchaseProductDeatils');
        Route::Post('/purchasePayment', [App\Http\Controllers\API\PurchaseController::class, 'purchasePayment'])->name('purchasePayment');

        Route::Post('filterProduct', [App\Http\Controllers\API\PurchaseController::class, 'filterProduct'])->name('filterProduct');
        Route::Post('searchProduct', [App\Http\Controllers\API\PurchaseController::class, 'searchProduct'])->name('searchProduct');
        Route::post('get-current-purchase-batch-data', [App\Http\Controllers\API\PurchaseController::class, 'getCurrentBatchData'])->name('get.current-purchase-batch-data');
        Route::post('purchaseInvoice', [App\Http\Controllers\API\PurchaseController::class, 'purchaseInvoice'])->name('purchaseInvoice');
        /*.............purchase route end....................*/


        //sell api route ...............
        Route::apiResource('sell', SellController::class);
        Route::get('/sellGetAllDetails', [App\Http\Controllers\API\SellController::class, 'sellGetAllDetails'])->name('sellGetAllDetails');
        Route::post('/get-purchase-product-batch', [App\Http\Controllers\API\SellController::class, 'getPurchaseProductBatch'])->name('getPurchaseProductBatch');

        Route::Post('/addSellDeatils', [App\Http\Controllers\API\SellController::class, 'addSellDeatils'])->name('addSellDeatils');
        Route::post('sellProductRemove', [App\Http\Controllers\API\SellController::class, 'sellProductRemove'])->name('sellProductRemove');

        Route::Post('/sell-payment', [App\Http\Controllers\API\SellController::class, 'sellPayment'])->name('sellPayment');

        Route::Post('sellFilterProduct', [App\Http\Controllers\API\SellController::class, 'sellFilterProduct'])->name('sellFilterProduct');
        Route::Post('sellSearchProduct', [App\Http\Controllers\API\SellController::class, 'sellSearchProduct'])->name('sellSearchProduct');


        Route::post('increment-sell-product', [App\Http\Controllers\API\SellController::class, 'incrementSellProduct'])->name('incrementSellProduct');
        Route::post('decrement-sell-product', [App\Http\Controllers\API\SellController::class, 'decrementSellProduct'])->name('decrementSellProduct');
        Route::post('update-sell-product-qty', [App\Http\Controllers\API\SellController::class, 'updateSellProductQty'])->name('updateSellProductQty');
        Route::get('sell-invoice/{id}', [App\Http\Controllers\API\SellController::class, 'sellInvoice'])->name('sellInvoice');
        /*.............Customer group and customer....................*/
        Route::get('get-customer-group', [App\Http\Controllers\API\SellController::class, 'getAllCustomerGroup'])->name('getAllCustomerGroup');
        Route::post('get-customer-with-customer-group', [App\Http\Controllers\API\SellController::class, 'getAllCustomer'])->name('getAllCustomer');



        /*.............sell route end....................*/


        //To profile update...
        Route::get('/profile', [ProfileController::class, 'getUserData'])->name('profile');
        Route::post('/profile/update', [ProfileController::class, 'profileUpdate'])->name('profile.update');
        Route::post('/profile/mobile/update', [ProfileController::class, 'profileMobileUpdate'])->name('profile.mobile.update');
        Route::post('/profile/mobile/verify', [ProfileController::class, 'profileMobileVerifyOtp'])->name('profile.mobile.update');
        Route::post('/profile/password/update', [ProfileController::class, 'securityUpdate'])->name('profile.password.update');

        //To logout user...
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');


        //Category Controller...
        Route::apiResource('category', CategoryController::class);
        Route::post('category/update/{id}', [App\Http\Controllers\API\CategoryController::class, 'update'])->name('category.update');
        Route::get('category/active/{id}', [App\Http\Controllers\API\CategoryController::class, 'activeDefaultCategory'])->name('category.active');
        Route::get('category/inactive/{id}', [App\Http\Controllers\API\CategoryController::class, 'inActiveDefaultCategory'])->name('category.inactive');

        //Brand Controller...
        Route::apiResource('brand',BrandController::class);
        Route::post('brand/update/{id}', [App\Http\Controllers\API\BrandController::class, 'update'])->name('brand.update');
        Route::delete('brand/delete/{id}', [App\Http\Controllers\API\BrandController::class, 'destroy'])->name('brand.delete');
        Route::get('brand/active/{id}', [App\Http\Controllers\API\BrandController::class, 'activeDefaultBrand'])->name('brand.active');
        Route::get('brand/inactive/{id}', [App\Http\Controllers\API\BrandController::class, 'inActiveDefaultBrand'])->name('brand.inactive');

        // Groupe Controller
        Route::apiResource('group', GroupController::class);
        Route::post('group/update/{id}', [App\Http\Controllers\API\GroupController::class, 'update'])->name('group.update');
        Route::delete('group/delete/{id}', [App\Http\Controllers\API\GroupController::class, 'destroy'])->name('group.delete');
        Route::get('group/active/{id}', [App\Http\Controllers\API\GroupController::class, 'activeDefaultGroup'])->name('group.active');
        Route::get('group/inactive/{id}', [App\Http\Controllers\API\GroupController::class, 'inActiveDefaultGroup'])->name('group.inactive');

        //  Unit Controller
        Route::apiResource('unit',UnitController::class);
        Route::post('unit/update/{id}', [App\Http\Controllers\API\UnitController::class, 'update'])->name('unit.update');
        Route::get('unit/active/{id}', [App\Http\Controllers\API\UnitController::class, 'activeDefaultUnit'])->name('unit.active');
        Route::get('unit/inactive/{id}', [App\Http\Controllers\API\UnitController::class, 'inActiveDefaultUnit'])->name('unit.inactive');

        //  Tax controller
        Route::apiResource('tax',TaxController::class);
        Route::post('tax/update/{id}', [App\Http\Controllers\API\TaxController::class, 'update'])->name('tax.update');
        Route::get('tax/active/{id}', [App\Http\Controllers\API\TaxController::class, 'activeDefaultTax'])->name('tax.active');
        Route::get('tax/inactive/{id}', [App\Http\Controllers\API\TaxController::class, 'inActiveDefaultTax'])->name('tax.inactive');

        //  Discount controller
        Route::apiResource('discount',DiscountController::class);
        Route::post('discount/update/{id}', [App\Http\Controllers\API\DiscountController::class, 'update'])->name('discount.update');
        Route::get('discount/active/{id}', [App\Http\Controllers\API\DiscountController::class, 'activeDefaultDiscount'])->name('discount.active');
        Route::get('discount/inactive/{id}', [App\Http\Controllers\API\DiscountController::class, 'inActiveDefaultDiscount'])->name('discount.inactive');

        // Product Controller
        Route::apiResource('product',ProductController::class);
        Route::post('product/update/{id}', [App\Http\Controllers\API\ProductController::class, 'update'])->name('product.update');
        Route::get('product/active/{id}', [App\Http\Controllers\API\ProductController::class, 'activeDefaultProduct'])->name('product.active');
        Route::get('product/inactive/{id}', [App\Http\Controllers\API\ProductController::class, 'inActiveDefaultProduct'])->name('product.inactive');


        // Customer Group Controller
        Route::apiResource('customer/group',CustomerGroupController::class);
        Route::post('customer/group/update/{id}', [App\Http\Controllers\API\CustomerGroupController::class, 'update'])->name('customerGroup.update');

        // customer controller
        Route::apiResource('customer',CustomerController::class);
        Route::post('customer/update/{id}', [App\Http\Controllers\API\CustomerController::class, 'update'])->name('customer.update');

        // Supplier Controller
        Route::apiResource('supplier', SupplierController::class);
        Route::post('supplier/update/{id}', [App\Http\Controllers\API\SupplierController::class, 'update'])->name('supplier.update');


         //Expense Category Controller
        Route::apiResource('expenseCategory', ExpenseCategoryController::class);
        Route::post('expenseCategory/update/{id}', [App\Http\Controllers\API\ExpenseCategoryController::class, 'update'])->name('expenseCategory.update');

        //Expense Controller
        Route::apiResource('expense', ExpenseController::class);
        Route::post('expense/update/{id}', [App\Http\Controllers\API\ExpenseController::class, 'update'])->name('expense.update');

        //purchase report route......
        Route::get('/purchase-todays-report', [App\Http\Controllers\API\PurchaseReportController::class, 'purchaseTodaysReport'])->name('purchase-todays-report');
        Route::get('/purchase-weekend-report', [App\Http\Controllers\API\PurchaseReportController::class, 'currentWeekendReport'])->name('purchase-weekend-report');
        Route::get('/purchase-month-report', [App\Http\Controllers\API\PurchaseReportController::class, 'currentMonthReport'])->name('purchase-month-report');

        Route::get('/purchase-daily-report-with-date', [App\Http\Controllers\API\PurchaseReportController::class, 'dailyReport'])->name('purchase-daily-report-with-date');
        Route::post('/purchase-daily-report-with-date', [App\Http\Controllers\API\PurchaseReportController::class, 'dailyReportWithDate'])->name('purchase-daily-report-with-date');

        Route::get('/purchase-monthly-report-with-month-name', [App\Http\Controllers\API\PurchaseReportController::class, 'monthlyReport'])->name('purchase-monthly-report-with-month-name');
        Route::post('/purchase-monthly-report-with-month-name', [App\Http\Controllers\API\PurchaseReportController::class, 'monthlyReportWithMonthName'])->name('purchase-monthly-report-with-month-name');

        Route::get('/purchase-report-with-between-date', [App\Http\Controllers\API\PurchaseReportController::class, 'reportWithBetweenDates'])->name('purchase-report-with-between-date');
        Route::post('/purchase-report-with-between-date', [App\Http\Controllers\API\PurchaseReportController::class, 'reportWithBetweenTwoDates'])->name('purchase-report-with-between-date');


        //purchase report route......
        Route::get('/sell-todays-report', [App\Http\Controllers\API\SellReportController::class, 'sellTodaysReport'])->name('sell-todays-report');
        Route::get('/sell-weekend-report', [App\Http\Controllers\API\SellReportController::class, 'currentWeekendReport'])->name('sell-weekend-report');
        Route::get('/sell-month-report', [App\Http\Controllers\API\SellReportController::class, 'currentMonthReport'])->name('sell-month-report');

        Route::get('/sell-daily-report-with-date', [App\Http\Controllers\API\SellReportController::class, 'dailyReport'])->name('sell-daily-report-with-date');
        Route::post('/sell-daily-report-with-date', [App\Http\Controllers\API\SellReportController::class, 'dailyReportWithDate'])->name('sell-daily-report-with-date');

        Route::get('/sell-monthly-report-with-month-name', [App\Http\Controllers\API\SellReportController::class, 'monthlyReport'])->name('sell-monthly-report-with-month-name');
        Route::post('/sell-monthly-report-with-month-name', [App\Http\Controllers\API\SellReportController::class, 'monthlyReportWithMonthName'])->name('sell-monthly-report-with-month-name');

        Route::get('/sell-report-with-between-date', [App\Http\Controllers\API\SellReportController::class, 'reportWithBetweenDates'])->name('sell-report-with-between-date');
        Route::post('/sell-report-with-between-date', [App\Http\Controllers\API\SellReportController::class, 'reportWithBetweenTwoDates'])->name('sell-report-with-between-date');


        // Setting Controller
        Route::apiResource('setting', SettingController::class);
        Route::post('setting/update/{id}', [App\Http\Controllers\API\SettingController::class, 'update'])->name('setting.update');

        // Company Profile Invoice controller
        Route::apiResource('companyInvoiceProfile', CompanyInvoiceProfileController::class);
        Route::post('companyInvoiceProfile/update/{id}', [App\Http\Controllers\API\CompanyInvoiceProfileController::class, 'update'])->name('companyInvoiceProfile.update');

        // Parcel Controller
        Route::apiResource('parcel', ParcelController::class);
        Route::post('parcel/update/{id}', [App\Http\Controllers\API\ParcelController::class, 'update'])->name('parcel.update');

        // Parcel Type Controller
        Route::apiResource('parceltype', ParcelTypeController::class);
        Route::post('parceltype/update/{id}', [App\Http\Controllers\API\ParcelTypeController::class, 'update'])->name('parceltype.update');

         // Parcel Type Controller
        Route::apiResource('deliveryOption', DeliveryOptionController::class);
        Route::post('deliveryOption/update/{id}', [App\Http\Controllers\API\DeliveryOptionController::class, 'update'])->name('deliveryOption.update');

         // Order Status Controller
        Route::apiResource('orderStatus', OrderStatusController::class);
        Route::post('orderStatus/update/{id}', [App\Http\Controllers\API\OrderStatusController::class, 'update'])->name('orderStatus.update');

         // Stock System Controller...
        Route::apiResource('stock', StockController::class);
        Route::get('stock-alert', [App\Http\Controllers\API\StockController::class, 'stockAlert'])->name('stockAlert');

        Route::apiResource('damage', DamageController::class);
    });

});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
