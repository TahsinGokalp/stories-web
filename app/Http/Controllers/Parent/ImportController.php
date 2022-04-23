<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportBookRequest;
use App\Services\Parent\ImportService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use function view;

class ImportController extends Controller
{
    protected ImportService $import;

    public function __construct(ImportService $import)
    {
        $this->import = $import;
    }

    public function index(): Factory|View|Application
    {
        return view('parent.import.index');
    }

    public function start(ImportBookRequest $request): RedirectResponse
    {
        $this->import->start($request);

        return redirect()->route('books')->with([
            'message' => 'Kitap içe aktarıldı.',
        ]);
    }
}
