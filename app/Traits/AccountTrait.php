<?php

namespace App\Traits;

use App\Models\Account;

trait AccountTrait
{
    public function getAccount(): Account
    {
        return session('account');
    }
}
