<?php

namespace App\Service;

use Illuminate\Support\Facades\Session;
class Sessions
{
    public static function SaveToSession($account, $user, $company): void
    {
        $accountData = [
            'FirstName' => $user->FirstName,
            'LastName' => $user->LastName,
            'Email' => $user->email,
            'JobTitle' => $account->JobTitle,
            'CompanyData' =>
                        [
                            'CompanyName' => $company->Name,
                            'CompanyId' => $company->id
                        ],
            'AccountId' => $account->id,
        ];

        Session::put('account', $accountData);
    }
}
