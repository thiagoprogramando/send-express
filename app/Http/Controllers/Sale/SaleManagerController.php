<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleManagerController extends Controller {

    public function listSales(Request $request) {

        $query = Sale::query();

        if ($request->input('id_client')) {
            $query->where('id_client', $request->input('id_client'));
        }

        if ($request->input('id_product')) {
            $query->where('id_product', $request->input('id_product'));
        }

        if ($request->input('method')) {
            $query->where('method', $request->input('method'));
        }

        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->input('created_at')) {
            $query->date('created_at', $request->input('created_at'));
        }

        $sales = $query->orderBy('created_at', 'asc')->paginate(30);

        return view('app.Sale.list-sale', [
            'sales'     => $sales,
            'clients'   => User::where('role', 'client')->where('id_indicator', Auth::user()->id)->orderBy('name', 'asc')->get(),
            'products'  => Product::where('id_user', Auth::user()->id)->get(),
        ]);
    }
}
