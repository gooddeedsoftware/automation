<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ManagesCreditTransactions;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    use ManagesCreditTransactions;

    public function deductCredits(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'string|max:255'
        ]);
        $user = $request->user();
        try {
            $transaction = $this->deductUserCredits(
                $user,
                $request->amount,
                $request->description
            );

            return response()->json([
                'message' => 'Credits deducted successfully',
                'transaction_id' => $transaction->id,
                'user_id' => $user->id,
                'credits' => $user->credits
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to deduct credits: ' . $e->getMessage()
            ], 400);
        }
    }

    public function addCredits(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'string|max:255'
        ]);

        $user = $request->user();

        try {
            $transaction = $this->addUserCredits(
                $user,
                $request->amount,
                $request->description
            );

            return response()->json([
                'message' => 'Credits added successfully',
                'transaction_id' => $transaction->id,
                'user_id' => $user->id,
                'credits' => $user->credits
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to add credits: ' . $e->getMessage()
            ], 400);
        }
    }

    public function getCredits(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user_id' => $user->id,
            'credits' => $user->credits
        ]);
    }
}
