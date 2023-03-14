<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Services\Parent\UsageService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

use function view;

class UsageController extends Controller
{
    protected UsageService $usage;

    public function __construct(UsageService $usage)
    {
        $this->usage = $usage;
    }

    public function index(): Factory|View|Application
    {
        return view('parent.usage.index', [
            'usage' => $this->usage->get(),
        ]);
    }
}
