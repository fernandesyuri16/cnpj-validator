<?php

namespace App\Http\Controllers;

use App\Helpers\Http;
use App\Http\Requests\CnpjValidator\StoreCnpjValidatorRequest;
use App\Http\Requests\CnpjValidator\UpdateCnpjValidatorRequest;
use App\Services\CnpjValidatorService;
use Illuminate\Http\JsonResponse;

/**
 * Class CnpjValidatorController
 *
 * This class is responsible for handling operations related to holiday plans.
 */
class CnpjValidatorController extends Controller
{
    use Http;

    /**
     * @var CnpjValidatorService Cnpj validator service
     */
    private CnpjValidatorService $service;

    public function __construct(CnpjValidatorService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        try {
            $data = $this->service->getCnpjValidators();

            return response()->json($data['response'], $data['code']);
        } catch (\Throwable $th) {
            $data = $this->serverError();

            return response()->json($data['response'], $data['code']);
        }
    }

    public function store(StoreCnpjValidatorRequest $request): JsonResponse
    {
        try {
            $data = $this->service->createCnpjValidator($request->validated());

            return response()->json($data['response'], $data['code']);
        } catch (\Throwable $th) {
            $data = $this->serverError();

            return response()->json($data['response'], $data['code']);
        }
    }

    public function show(int $cnpjValidatorId): JsonResponse
    {
        try {
            $data = $this->service->getCnpjValidator($cnpjValidatorId);

            return response()->json($data['response'], $data['code']);
        } catch (\Throwable $th) {
            $data = $this->serverError();

            return response()->json($data['response'], $data['code']);
        }
    }

    public function update(int $cnpjValidatorId, UpdateCnpjValidatorRequest $request): JsonResponse
    {
        try {
            $data = $this->service->updateCnpjValidator($cnpjValidatorId, $request->validated());

            return response()->json($data['response'], $data['code']);
        } catch (\Throwable $th) {
            $data = $this->serverError();

            return response()->json($data['response'], $data['code']);
        }
    }

    public function destroy(int $cnpjValidatorId): JsonResponse
    {
        try {
            $data = $this->service->deleteCnpjValidator($cnpjValidatorId);

            return response()->json($data['response'], $data['code']);
        } catch (\Throwable $th) {
            $data = $this->serverError();

            return response()->json($data['response'], $data['code']);
        }
    }
}
