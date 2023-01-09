<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Repositories\PersonsRepository;
use App\Services\PersonsService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @author Chiragkumar Patel
 */
class FileUploadController extends Controller
{

    protected PersonsService $persons_service;
    protected PersonsRepository $persons_repository;

    /**
     * @param PersonsService $persons_service
     * @param PersonsRepository $persons_repository
     */
    public function __construct(PersonsService $persons_service, PersonsRepository $persons_repository)
    {
        $this->persons_service = $persons_service;
        $this->persons_repository = $persons_repository;
    }

    /**
     * Manage the upload and handle parse of CSV
     * @param FileUploadRequest $request
     * @return JsonResponse
     */
    public function upload(FileUploadRequest $request): JsonResponse
    {
        $file = $request->file('csv_file');
        if ($request->file('csv_file')) {
            $path = Storage::disk('public_uploads')->put('/', $file, 'public');
            $filepath = public_path("uploads/" . $path);

            // Delete all records so only display the uploaded csv
            $this->persons_repository->deleteAll();

            // Handling the parsing of CSV
            try {
                $this->persons_service->parse($filepath);
            } catch (Exception $e) {
                return response()->json(['message' => 'Something went wrong']);
            }
            return response()->json(['message' => 'File is uploaded'], ResponseAlias::HTTP_CREATED);
        } else {
            return response()->json(['message' => 'CSV file is not provided']);
        }

    }

    /**
     * @return Collection
     */
    public function getAllPersonDetails(): Collection
    {
        return $this->persons_repository->getAll();
    }
}
