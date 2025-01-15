<?php

namespace App\Trait;

trait Account
{
    public function getAccount()
    {
        return session('account');
    }
}
