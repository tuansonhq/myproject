<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(Request $request)
    {
//        $this->middleware('role:admin', ['only' => ['GrowthUser', 'ClassifyUser', 'GrowthTopupCard', 'GrowthStoreCard', 'GrowthTopupBank', 'GrowthDonate', 'ExportDepositBank', 'ExportCharge', 'ExportStoreCard', 'ExportDonate', 'ExportIdolBookingTime', 'ExportUserBirthday', 'classifyShopGroup', 'GrowthShop', 'ReportCharge', 'ReportStoreCard', 'GrowthTranfer', 'ReportTranfer','ReportWithdrawItem','ReportPointOfSale','ReportTopMoney','ReportSurplusUser','ReportTransactionUser','ReportUser','ReportMinigame','ReportTransfer2','ReportServiceAuto','ReportService','ReportWithdraw','ReportMoney','ReportStoreCard2','ReportCharge2']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Dashboard';
        $page_breadcrumbs = [
            ['page' => '1',
                'title' => 'Home',
            ],
        ];
        ActivityLog::add($request, 'Truy cập dashboard index');
        return view('admin.index', compact('page_title', 'page_breadcrumbs'));
    }
}
