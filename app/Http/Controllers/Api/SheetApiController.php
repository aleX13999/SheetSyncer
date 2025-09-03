<?php

namespace App\Http\Controllers\Api;

use App\Application\Sheet\Url\Services\SheetUrlService;
use App\Http\Controllers\Controller;
use App\Services\Synchronization\Csv\CsvSynchronization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SheetApiController extends Controller
{
    public function __construct(
        private readonly SheetUrlService    $sheetUrlService,
        private readonly CsvSynchronization $csvSynchronization,
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

    public function showCsv(Request $request): JsonResponse
    {
        $validated = $request->validate(
            [
                'count' => 'sometimes|int',
            ],
        );

        $count = $validated['count'] ?? null;

        $data = $this->csvSynchronization->loadData();

        array_shift($data);

        if ($count > 0) {
            $notes = array_slice($data, 0, $count);
        } else {
            $notes = $data;
        }

        $result = [];

        foreach ($notes as $note) {
            $result[] = array_shift($note) . ' / ' . array_pop($note);
        }

        return new JsonResponse(['data' => $result]);
    }
}
