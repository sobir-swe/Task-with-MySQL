<?php

namespace App\Service;

use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SessionAccount
{
	public static function SaveToSession(): void
	{
		$user_id = auth()->id();
		$client = Account::select([
				'accounts.*',
				'u.FirstName',
				'u.LastName',
				'u.email',
				'c.Name as CompanyName',
			])
			->join('users as u', 'u.id', '=', 'accounts.UserId')
			->join('companies as c', 'c.id', '=', 'accounts.CompanyId')
			->where('accounts.UserId', $user_id)
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
