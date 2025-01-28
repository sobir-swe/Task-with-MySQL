<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SessionAccount
{
    public static function SaveToSession(): void
    {
        $user_id = auth()->id();
        $client = DB::table('accounts AS a')
            ->join('users as u', 'u.id', '=', 'a.UserId')
            ->join('companies as c', 'c.id', '=', 'a.CompanyId')
            ->where('a.UserId', $user_id)
            ->select(
                'u.FirstName',
                'u.LastName',
                'u.email',
                'c.Name as CompanyName',
                'a.*'
            )
            ->first();

        Session::put('client', $client);
    }


    public static function GetSession()
    {
        return Session::get('client');
    }

    public static function SendLog($file): void
    {
        $client = session('client');

        Log::info('Yangi fayl yaratildi', [
            'FirstName' => $client->FirstName,
            'LastName' => $client->LastName,
            'email' => $client->email,
            'File' => $file->getClientOriginalName(),
        ]);
    }
}
