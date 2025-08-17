<?php

namespace App\Http\Controllers\Api;

use App\Application\Note\DTO\NoteCreateData;
use App\Application\Note\DTO\NoteUpdateData;
use App\Application\Note\Exception\NoteException;
use App\Application\Note\Exception\NoteValidationException;
use App\Application\Note\Services\NoteCreator;
use App\Application\Note\Services\NoteDeleter;
use App\Application\Note\Services\NoteGenerator;
use App\Application\Note\Services\NoteGetter;
use App\Application\Note\Services\NoteUpdater;
use App\Http\Controllers\Controller;
use App\Http\Requests\Note\NoteCreateRequest;
use App\Http\Requests\Note\NoteUpdateRequest;
use App\Http\Resources\Note\NoteResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoteApiController extends Controller
{
    public function __construct(
        private readonly NoteGetter    $getter,
        private readonly NoteCreator   $creator,
        private readonly NoteUpdater   $updater,
        private readonly NoteGenerator $generator,
        private readonly NoteDeleter   $deleter,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $notes = $this->getter->getAll();

        return new JsonResponse(['data' => NoteResource::collection($notes)], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteCreateRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $createData = new NoteCreateData();
        $createData
            ->setTitle($validated['title'])
            ->setDescription($validated['description'])
            ->setStatus($validated['status']);

        try {
            $note = $this->creator->create($createData);
        } catch (NoteValidationException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 422);
        } catch (NoteException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return new JsonResponse(['data' => new NoteResource($note)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $note = $this->getter->get($id);
        } catch (NoteException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 404);
        }

        return new JsonResponse(['data' => new NoteResource($note)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NoteUpdateRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();

        $updateData = new NoteUpdateData($id);

        if (array_key_exists('title', $validated)) {
            $updateData->setTitle($validated['title']);
        }

        if (array_key_exists('description', $validated)) {
            $updateData->setDescription($validated['description']);
        }

        if (array_key_exists('status', $validated)) {
            $updateData->setStatus($validated['status']);
        }

        try {
            $note = $this->updater->update($updateData);
        } catch (NoteValidationException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 422);
        } catch (NoteException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return new JsonResponse(['data' => new NoteResource($note)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->deleter->delete($id);

        } catch (NoteException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 404);
        }

        return new JsonResponse(['success' => true]);
    }

    public function generate(Request $request): JsonResponse
    {
        $validated = $request->validate(
            [
                'count' => 'sometimes|integer|min:1',
            ],
        );

        if (isset($validated['count'])) {
            $this->generator->generate($validated['count']);
        } else {
            $this->generator->generate();
        }

        return new JsonResponse(['success' => true, 'message' => 'Notes successfully generated.']);
    }

    public function clear(): JsonResponse
    {
        try {
            $this->deleter->deleteAll();
        } catch (NoteException $e) {
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }

        return new JsonResponse(['success' => true]);
    }
}
