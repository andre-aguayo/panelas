<?php

namespace App\Services;

use App\EnumTypes\UFEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface CompanyServiceInterface
{
    /**
     * List of companies
     * @param array $request search parameters
     * @return Collection of companies
     */
    public function list(array $request): Collection;

    /**
     * List of states in using
     * @return array of states
     */
    public function getValidUF(): array;

    /**
     * List of cities from state
     * @param Request $request UF parameter of search cities
     * @return array states
     */
    public function getValidStateCities(UFEnum $uf): array;

    /**
     * List of valid cities
     * @return array used cities 
     */
    public function getValidCity(): array;

    /**
     * @param string $email to sending
     * @return bool email exist? 
     */
    public function checkIfEmailExist(string $email): bool;
}
