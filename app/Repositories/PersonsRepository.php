<?php

namespace App\Repositories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Collection;

/**
 * @author Chiragkumar Patel
 */
class PersonsRepository
{

    private Person $person;

    /**
     * @param Person $person
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    /**
     * Delete all records so only display uploaded records
     * @param array $person
     * @return Person
     */
    public function create(array $person): Person
    {
        return $this->person->create($person);
    }

    /**
     * Get all person records
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->person->all();
    }

    /**
     * Remove old person records
     * @return mixed
     */
    public function deleteAll(): mixed
    {
        return $this->person->truncate();
    }
}
