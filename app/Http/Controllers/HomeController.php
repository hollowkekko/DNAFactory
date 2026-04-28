<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(private DashboardService $dashboardService)
    {
    }

    public function index()
    {
        $user = Auth::user();

        $data = array_merge(
            $this->dashboardService->getAnimeData($user),
            $this->dashboardService->getMangaData($user)
        );

        return view('dashboard', $data);
    }
}

