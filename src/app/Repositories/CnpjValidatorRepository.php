<?php

namespace App\Repositories;

use App\Interfaces\CnpjValidatorRepositoryInterface;
use App\Models\CnpjValidator;
use Illuminate\Pagination\Paginator;

class CnpjValidatorRepository implements CnpjValidatorRepositoryInterface
{
    public function createCnpjValidator(array $holidayPlanDetails): CnpjValidator
    {
        return CnpjValidator::create($holidayPlanDetails);
    }

    public function getCnpjValidator(int $cnpjValidatorId): ?CnpjValidator
    {
        return CnpjValidator::find($cnpjValidatorId);
    }

    public function getCnpjValidators(): Paginator
    {
        return CnpjValidator::simplePaginate(10);
    }

    public function updateCnpjValidator(int $cnpjValidatorId, array $holidayPlanDetails): void
    {
        CnpjValidator::whereId($cnpjValidatorId)->update($holidayPlanDetails);
    }

    public function deleteCnpjValidator(int $cnpjValidatorId): void
    {
        CnpjValidator::destroy($cnpjValidatorId);
    }
}
