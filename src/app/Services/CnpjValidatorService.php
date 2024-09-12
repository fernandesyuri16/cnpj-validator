<?php

namespace App\Services;

use App\Helpers\Http;
use App\Repositories\CnpjValidatorRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;

class CnpjValidatorService
{
    use Http;

    private CnpjValidatorRepository $repository;

    public function __construct()
    {
        $this->repository = new CnpjValidatorRepository;
    }

    /**
     * Create a new cnpj validator.
     *
     * @param array $holidayPlanDetails - Details of the cnpj validator.
     * @return array - Returns an array with the created cnpj validator or an error message.
     */
    public function createCnpjValidator(array $cnpjValidatorDetails): array
    {
        $cnpjValidatorDetails['user_id'] = auth()->user()->id;

        $datenow = Carbon::now();

        if ($cnpjValidatorDetails['date'] < $datenow) {
            return $this->unprocessableEntity("Data deverá ser superior");
        }

        $cnpjValidator = $this->repository->createCnpjValidator($cnpjValidatorDetails);

        return $this->created($cnpjValidator);
    }

    /**
     * Get a specific cnpj validator.
     *
     * @param int $cnpjValidatorId - The ID of the cnpj validator.
     * @return array - Returns an array with the cnpj validator or an error message.
     */
    public function getCnpjValidator(int $cnpjValidatorId): array
    {
        $error = $this->checkIfHasError($cnpjValidatorId);

        if (! empty($error)) {
            return $error;
        }

        $cnpjValidator = $this->repository->getCnpjValidator($cnpjValidatorId);

        return $this->ok($cnpjValidator);
    }

    /**
     * Get all cnpj validators.
     *
     * @return array - Returns an array with all cnpj validators.
     */
    public function getCnpjValidators(): array
    {
        $cnpjValidator = $this->repository->getCnpjValidators();

        return $this->ok($cnpjValidator->items());
    }

    /**
     * Check if there are any errors.
     *
     * @param int $cnpjValidatorId - The ID of the cnpj validator.
     * @param bool $checkPermission - Whether to check for permissions.
     * @return array - Returns an array with an error message if there are any errors.
     */
    private function checkIfHasError(int $cnpjValidatorId, bool $checkPermission = false): array
    {
        $cnpjValidatorDetails = $this->repository->getCnpjValidator($cnpjValidatorId);

        if (! $this->cnpjValidatorExists($cnpjValidatorId)) {
            return $this->notFound("Cnpj doesn't exists.");
        }

        if ($checkPermission && $cnpjValidatorDetails['user_id'] !== auth()->user()->id) {
            return $this->forbidden("You don't have permission to perform this action.");
        }

        return [];
    }

    /**
     * Check if a Cnpj exists.
     *
     * @param int $cnpjValidatorId - The ID of the Cnpj.
     * @return bool - Returns true if the Cnpj exists, false otherwise.
     */
    private function cnpjValidatorExists(int $cnpjValidatorId): bool
    {
        $cnpjValidator = $this->repository->getCnpjValidator($cnpjValidatorId);

        if (empty($cnpjValidator->id)) {
            return false;
        }

        return true;
    }

    /**
     * Update a specific Cnpj.
     *
     * @param int $cnpjValidatorId - The ID of the Cnpj.
     * @param array $cnpjValidatorDetails - The new details of the Cnpj.
     * @return array - Returns an array with the updated Cnpj or an error message.
     */
    public function updateCnpjValidator(int $cnpjValidatorId, array $cnpjValidatorDetails): array
    {
        $error = $this->checkIfHasError($cnpjValidatorId, true);

        if (! empty($error)) {
            return $error;
        }

        $this->repository->updateCnpjValidator($cnpjValidatorId, $cnpjValidatorDetails);

        $cnpjValidator = $this->repository->getCnpjValidator($cnpjValidatorId);

        return $this->ok($cnpjValidator);
    }

    /**
     * Delete a specific cnpj validator.
     *
     * @param int $cnpjValidatorId - The ID of the cnpj validator.
     * @return array - Returns an array with a success message or an error message.
     */
    public function deleteCnpjValidator(int $cnpjValidatorId): array
    {
        $error = $this->checkIfHasError($cnpjValidatorId, true);

        if (! empty($error)) {
            return $error;
        }

        $this->repository->deleteCnpjValidator($cnpjValidatorId);

        return $this->ok('Cnpj successfully deleted!');
    }
}
