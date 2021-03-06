<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Deposit;
//use App\Events\TestEvent;

class PortfolioController extends Controller
{
    public function index()
    {
        return view('live');
    }

    public function live()
    {
        $customers = Customer::orderBy('id', 'desc')->limit(10)->get();
        $total_member = Customer::count();
        $last_deposits = Deposit::with('owner')->orderBy('id', 'desc')->limit(10)->get();
        $invested_capital = Deposit::sum('amount');

        return [
            'customers' => $customers,
            'total_member' => $total_member,
            'last_deposits' => $last_deposits,
            'invested_capital' => $invested_capital,
        ];
    }
}
