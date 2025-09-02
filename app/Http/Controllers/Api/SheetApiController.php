<?php

namespace App\Http\Controllers\Api;

use App\Application\Sheet\Url\Services\SheetUrlService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SheetApiController extends Controller
{
    public function __construct(
        private readonly SheetUrlService $sheetUrlService,
    ) {}

    public function index(): JsonResponse
    {
        return new JsonResponse(['data' => $this->sheetUrlService->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate(
            [
                'url' => 'required|url',
            ],
        );

        try {
            $this->sheetUrlService->create($validated['url']);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return new JsonResponse(['success' => true]);
    }
}
