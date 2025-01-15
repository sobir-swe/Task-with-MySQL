<?php

namespace App\Trait;

trait AccountTrait
{
    public function getAccount()
    {
        return session('account');
    }
}
