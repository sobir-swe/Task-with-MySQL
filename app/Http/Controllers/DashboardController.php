<?php

namespace App\Http\Controllers;

use App\Service\Sessions;
use App\Trait\AccountTrait;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use AccountTrait;

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('dashboard');
    }

}
