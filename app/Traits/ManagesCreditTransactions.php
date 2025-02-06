<?php

namespace App\Traits;

use App\Models\User;
use App\Models\CreditTransaction;
use Illuminate\Support\Facades\DB;

trait ManagesCreditTransactions
{
    protected function handleCreditTransaction(User $user, float $amount, string | null $description, string $type = 'credit')
    {
        return DB::transaction(function () use ($user, $amount, $description, $type) {
            if ($type === 'debit') {
                if ($user->credits < $amount) {
                    throw new \Exception('Insufficient credits');
                }
                $user->credits -= $amount;
            } else {
                $user->credits += $amount;
            }

            $user->save();

            return CreditTransaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => $type,
                'description' => $description,
                'balance_after' => $user->credits
            ]);
        });
    }

    protected function addUserCredits(User $user, float $amount, string | null $description)
    {
        return $this->handleCreditTransaction($user, $amount, $description, 'credit');
    }

    protected function deductUserCredits(User $user, float $amount, string | null $description)
    {
        return $this->handleCreditTransaction($user, $amount, $description, 'debit');
    }
}
