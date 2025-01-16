<?php

namespace App\Traits;

trait AccountTrait
{
    public function getAccount()
    {
        return session('account');
    }
}
