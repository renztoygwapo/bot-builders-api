<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface Repository
{
    /**
     * Set specified Model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param Model
     */
    public function __construct(Model $model);

    /**
     * Create query for searching and sorting of the resource.
     *
     * @param array $data
     * @return query
     */
    public function index(array $data);

    /**
     * Apply Order By method.
     *
     * @param array $data = []
     * @return query
     */
    public function sortBy(array $data = []);

    /**
     * Get all listing of the resource.
     *
     * @return array
     */
    public function all();

    /**
     * Count all resource.
     *
     * @return int
     */
    public function count();

    /**
     * Store newly created resource in storage.
     *
     * @param array $data
     * @return resource
     */
    public function store(array $data);

    /**
     * Store many newly created resource in storage
     * Note : using this method in storing will not automatically store created_at.
     *
     * @param array $data
     * @return array of resource
     */
    public function insert(array $data);

    /**
     * Store newly created resource or return the first resource that matches the $matching_fields parameter.
     *
     * @param array $matching_fields
     * @param array $extra_data
     * @return resource
     */
    public function fc(array $matching_fields, array $extra_data);

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return resource
     */
    public function find(int $id);

    /**
     * Display the specified resource and throw error if not found.
     *
     * @param int $id
     * @return resource
     */
    public function ff(int $id);

    /**
     * Update the specified resource.
     *
     * @param array $data
     * @param int $id
     * @return resource
     */
    public function update(array $data, $id);

    /**
     * Remove the specified resource from storage by ID.
     *
     * @param int $id
     * @return resource
     */
    public function destroy(int $id);

    /**
     * Remove the specified resource from storage by UUID.
     *
     * @param string $uuid
     * @return resource
     */
    public function destroyByUuid(string $uuid);

    /**
     * Get the Initialized Model.
     *
     * @return model
     */
    public function model();

    /**
     * Get the Initialized Model Table.
     *
     * @return model's table
     */
    public function table();

    /**
     * Display the specified resource by uuid.
     *
     * @param string $uuid
     * @return resource
     */
    public function findByUuid(string $uuid);
}
