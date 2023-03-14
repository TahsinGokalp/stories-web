<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExportBookRequest;
use App\Services\Parent\ExportService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use function view;

class ExportController extends Controller
{
    protected ExportService $export;

    public function __construct(ExportService $export)
    {
        $this->export = $export;
    }

    public function index(): Factory|View|Application
    {
        return view('parent.export.index', [
            'books' => $this->export->books(),
        ]);
    }

    public function download(ExportBookRequest $request): BinaryFileResponse
    {
        return $this->export->download($request);
    }
}
