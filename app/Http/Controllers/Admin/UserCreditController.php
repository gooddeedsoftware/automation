<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CreditTransaction;
use App\Traits\ManagesCreditTransactions;
use Illuminate\Http\Request;

class UserCreditController extends Controller
{
    use ManagesCreditTransactions;

    public function index(User $user)
    {
        $transactions = $user->creditTransactions()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.credits.index', [
            'user' => $user,
            'transactions' => $transactions
        ]);
    }

    public function addCredits(Request $request, User $user)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'string|max:255'
        ]);

        try {
            $transaction = $this->addUserCredits(
                $user,
                $validated['amount'],
                $validated['description']
            );

            return redirect()
                ->route('admin.users.credits.index', $user)
                ->with('success', "Successfully added {$validated['amount']} credits to user's account.");
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.users.credits.index', $user)
                ->with('error', 'Failed to add credits: ' . $e->getMessage());
        }
    }

    public function deductCredits(Request $request, User $user)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'string|max:255'
        ]);

        try {
            $transaction = $this->deductUserCredits(
                $user,
                $validated['amount'],
                $validated['description']
            );

            return redirect()
                ->route('admin.users.credits.index', $user)
                ->with('success', "Successfully deducted {$validated['amount']} credits from user's account.");
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.users.credits.index', $user)
                ->with('error', 'Failed to deduct credits: ' . $e->getMessage());
        }
    }
}
