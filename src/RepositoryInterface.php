<?php

/**
 * Implements CRUD
 */
interface RepositoryInterface
{
    public function create(array $data);

    public function read(int $id);

    public function readMultiple(array $filters, array $fields = []): array;

    public function readAll(bool $reverse = false): array;

    public function update(int $id, array $data);

    public function delete(int $id);


}