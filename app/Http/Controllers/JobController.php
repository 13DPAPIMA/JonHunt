<?php

namespace App\Http\Controllers;

use App\Models\JobAdvertisement;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function pay(Request $request, JobAdvertisement $jobAd)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'requirements' => 'required|string'
        ]);
    
        $total = $jobAd->Price * $request->input('quantity');
    
        $userBalance = auth()->user()->balance;
    
        if (!$userBalance) {
            return response()->json(['message' => 'Баланс пользователя не найден.'], 404);
        }
    
        if ($userBalance->amount < $total) {
            return response()->json(['message' => 'Недостаточно средств на балансе.'], 400);
        }
    
        $userBalance->amount -= $total;
        $userBalance->save();
    
        return response()->json(['message' => 'Услуга успешно оплачена!'], 200);
    }
    
    
}
