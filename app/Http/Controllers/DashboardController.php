<?php

namespace App\Http\Controllers;

use App\Service\SessionAccount;
use App\Traits\AccountTrait;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use AccountTrait;

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('dashboard');
    }

}
