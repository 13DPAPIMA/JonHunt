<?php

namespace App\Http\Controllers;

use App\Models\UserBalance;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BalanceController extends Controller
{
    public function index()
    {
        $userBalance = auth()->user()->balance;
    
        if (!$userBalance) {
            $userBalance = UserBalance::create([
                'user_id' => auth()->id(),
                'amount' => 0,
            ]);
        }
    
        return Inertia::render('Balance/AddBalance', [
            'balance' => $userBalance->amount,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:999',
        ]);

        $userBalance = auth()->user()->balance;
        $userBalance->amount += $request->input('amount');
        $userBalance->save();

        return redirect()->route('dashboard')->with('success', 'Баланс успешно пополнен!');
    }
}
