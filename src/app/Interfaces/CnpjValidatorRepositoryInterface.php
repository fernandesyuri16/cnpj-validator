<?php

namespace App\Interfaces;

interface CnpjValidatorRepositoryInterface
{
    public function createCnpjValidator(array $cnpjValidatorDetails);
    public function getCnpjValidator(int $cnpjValidatorId);
    public function getCnpjValidators();
    public function updateCnpjValidator(int $cnpjValidatorId, array $cnpjValidatorDetails);
    public function deleteCnpjValidator(int $cnpjValidatorId);
}
