<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BranchProductController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CashInController;
use App\Http\Controllers\CashoutController;
use App\Http\Controllers\CashReceiptController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\PayExpenseController;
use App\Http\Controllers\PayinvoiceController;
use App\Http\Controllers\PaymentFormController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PayorderController;
use App\Http\Controllers\PayPurchaseController;
use App\Http\Controllers\ProductBranchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RestaurantTableController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleboxController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UnitMeasureController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationCodeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::resource('user', UserController::class);
Route::resource('document', DocumentController::class);
Route::resource('role', RoleController::class);
Route::resource('department', DepartmentController::class);
Route::resource('municipality', MunicipalityController::class);
Route::resource('bank', BankController::class);
Route::resource('card', CardController::class);
Route::resource('company', CompanyController::class);
Route::resource('branch', BranchController::class);
Route::resource('payment_form', PaymentFormController::class);
Route::resource('payment_method', PaymentMethodController::class);
Route::resource('category', CategoryController::class);
Route::resource('product', ProductController::class);
Route::resource('branch_product', BranchProductController::class);
Route::resource('transfer', TransferController::class);
Route::resource('product_branch', ProductBranchController::class);
Route::resource('supplier', SupplierController::class);
Route::resource('purchase', PurchaseController::class);
Route::resource('customer', CustomerController::class);
Route::resource('invoice', InvoiceController::class);
Route::resource('pay_purchase', PayPurchaseController::class);
Route::resource('order', OrderController::class);
Route::resource('pay_order', PayorderController::class);
Route::resource('pay_invoice', PayinvoiceController::class);
Route::resource('order_product', OrderProductController::class);
Route::resource('sale_box', SaleboxController::class);
Route::resource('verification_code', VerificationCodeController::class);
Route::resource('cash_out', CashoutController::class);
Route::resource('kardex', KardexController::class);
Route::resource('report', ReportController::class);
Route::resource('unit_measure', UnitMeasureController::class);
Route::resource('expense', ExpenseController::class);
Route::resource('pay_expense', PayExpenseController::class);
Route::resource('service', ServiceController::class);
Route::resource('cash_in', CashInController::class);
Route::resource('menu', MenuController::class);
Route::resource('cash_receipt', CashReceiptController::class);
Route::resource('restaurantTable', RestaurantTableController::class);

Route::get('branch/create/{id}', [BranchController::class, 'getMunicipalities']);
Route::get('show_purchase/{id}', [BranchController::class, 'show_purchase'])->name('show_purchase');
Route::get('branch/show_expense/{id}', [BranchController::class, 'show_expense'])->name('show_expense');
Route::get('show_invoice/{id}', [BranchController::class, 'show_invoice'])->name('show_invoice');
Route::get('show_order/{id}', [BranchController::class, 'show_order'])->name('show_order');
Route::get('show_product/{id}', [BranchController::class, 'show_product'])->name('show_product');
Route::get('show_transfer/{id}', [BranchController::class, 'show_transfer'])->name('show_transfer');
Route::get('show_sale_box/{id}', [BranchController::class, 'show_sale_box'])->name('show_sale_box');
Route::post('branch/logout', [BranchController::class, 'logout'])->name('logout_branch');

Route::get('company/create/{id}', [CompanyController::class, 'getMunicipalities']);
Route::post('company/logout', [CompanyController::class, 'logout'])->name('logout_company');

Route::get('indicator/restaurantStatus/{id}', [IndicatorController::class, 'restaurantStatus'])->name('restaurantStatus');

Route::get('customer/create/{id}', [CustomerController::class, 'getProducts']);
Route::get('customer/create/{id}', [CustomerController::class, 'getMunicipalities']);

Route::get('expense/show_pdf_expense/{id}', [ExpenseController::class, 'show_pdf_expense'])->name('show_pdf_expense');
Route::get('expense/show_pay_expense/{id}', [ExpenseController::class, 'show_pay_expense'])->name('show_pay_expense');
Route::get('expense/create/{id}', [InvoiceController::class, 'getMunicipalities']);
Route::get('expense/post_expense/{id}', [ExpenseController::class, 'post_expense'])->name('post_expense');

Route::get('invoice/show_pdf_invoice/{id}', [InvoiceController::class, 'show_pdf_invoice'])->name('show_pdf_invoice');
Route::get('invoice/show_pay_invoice/{id}', [InvoiceController::class, 'show_pay_invoice'])->name('show_pay_invoice');
Route::get('invoice/create/{id}', [InvoiceController::class, 'getMunicipalities']);
Route::get('invoice/post/{id}', [InvoiceController::class, 'post'])->name('post');
Route::get('invoicePdf', [InvoiceController::class, 'invoicePdf'])->name('invoicePdf');
Route::get('invoicePost', [InvoiceController::class, 'invoicePost'])->name('invoicePost');

Route::get('menu/status/{id}', [MenuController::class, 'status'])->name('menuStatus');

Route::get('order/show_invoicy/{id}', [orderController::class, 'show_invoicy'])->name('show_invoicy');
Route::get('order/show_pdf_order/{id}', [orderController::class, 'show_pdf_order'])->name('show_pdf_order');
Route::get('order/pdfOrder/{id}', [OrderController::class, 'pdfOrder'])->name('pdfOrder');
Route::get('orderPdf', [OrderController::class, 'orderPdf'])->name('orderPdf');
Route::get('order/postOrder/{id}', [OrderController::class, 'postOrder'])->name('postOrder');
Route::get('orderPost', [OrderController::class, 'orderPost'])->name('orderPost');
Route::get('order/eliminar/{id}', [orderController::class, 'eliminar'])->name('eliminar');

Route::get('pdf_pay_invoice/{id}', [PayinvoiceController::class, 'pdf_pay_invoice'])->name('pdf_pay_invoice');
Route::get('pdf_pay_purchase/{id}', [PayPurchaseController::class, 'pdf_pay_purchase'])->name('pdf_pay_purchase');
Route::get('pdfPayOrder/{id}', [PayorderController::class, 'pdfPayOrder'])->name('pdfPayOrder');
Route::get('pdfPayExpense/{id}', [PayExpenseController::class, 'pdfPayExpense'])->name('pdfPayExpense');
Route::get('detailPayPurchase', [PayPurchaseController::class, 'detailPay'])->name('detailPayPurchase');
Route::get('detailPayExpense', [PayExpenseController::class, 'detailPay'])->name('detailPayExpense');
Route::get('detailPayInvoice', [PayInvoiceController::class, 'detailPay'])->name('detailPayInvoice');


Route::get('product/status/{id}', [ProductController::class, 'status'])->name('productStatus');

Route::get('prosuc/crate/{id}', [ProductBranchController::class, 'getProducts']);

Route::get('show_pdf_purchase/{id}', [PurchaseController::class, 'show_pdf_purchase'])->name('show_pdf_purchase');
Route::get('show_pay_purchase/{id}', [PurchaseController::class, 'show_pay_purchase'])->name('show_pay_purchase');
Route::get('post_purchase/{id}', [PurchaseController::class, 'post_purchase'])->name('post_purchase');
Route::get('purchasePdf', [PurchaseController::class, 'purchasePdf'])->name('purchasePdf');
Route::get('purchasePost', [PurchaseController::class, 'purchasePost'])->name('purchasePost');
Route::get('purchase/create/{id}', [PurchaseController::class, 'getMunicipalities']);
Route::get('purchase/getPayment/{id}', [PurchaseController::class, 'getPayments'])->name('getPayment');

Route::get('portfolio', [ReportController::class, 'portfolio'])->name('portfolio');
Route::get('past_due_portfolio', [ReportController::class, 'past_due_portfolio'])->name('past_due_portfolio');
Route::get('portfolio_thirty', [ReportController::class, 'portfolio_thirty'])->name('portfolio_thirty');
Route::get('portfolio_sixty', [ReportController::class, 'portfolio_sixty'])->name('portfolio_sixty');
Route::get('daily_report', [ReportController::class, 'daily_report'])->name('daily_report');

Route::get('show_out/{id}', [saleboxController::class, 'show_out'])->name('show_out');
Route::get('show_pos/{id}', [saleboxController::class, 'show_pos'])->name('show_pos');
Route::get('show_close/{id}', [SaleboxController::class, 'show_close'])->name('show_close');
Route::get('show_cashIn/{id}', [SaleboxController::class, 'show_cashIn'])->name('show_cashIn');

Route::get('supplier/create/{id}', [SupplierController::class, 'getMunicipalities']);

Route::get('unitMeasure/status/{id}', [UnitMeasureController::class, 'status'])->name('unitStatus');

Route::get('status/{id}', [UserController::class, 'status'])->name('status');
Route::get('inactive', [UserController::class, 'inactive'])->name('inactive');
Route::post('user/logout', [UserController::class, 'logout'])->name('logout_user');
Route::get('user/show_code/{id}', [UserController::class, 'show_code'])->name('show_code');
Route::get('user/delete/{id}', [UserController::class, 'delete'])->name('delete');
