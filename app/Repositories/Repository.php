<?php

namespace App\Repositories;

use App\Interfaces\Repository as RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use League\Flysystem\Exception;

class Repository implements RepositoryInterface
{
    /**
     * Variable that holds the Model Class.
     *
     * @var class
     */
    protected $model;

    /**
     * Set specified Model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * This will directly call the model's method.
     * Note : It will only called if the method doesn't exist in this class.
     *
     * @param string $method
     * @param $arguments
     * @return void
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->model, $method], $arguments);
    }

    /**
     * Create query for searching and sorting of the resource.
     *
     * @param array $data
     * @return query
     */
    public function index(array $data)
    {
        try {
            $items = $this->model
            // Determine if the request has search
            ->when(isset($data['search']), function ($q) use ($data) {
                $q->where(function ($q) use ($data) {
                    $searchFields = explode(',', $data['s_fields']);
                    foreach ($searchFields as $key => $field) {
                        if (! $key) {
                            $q->where($field, 'like', '%'.$data['search'].'%');
                        } else {
                            $q->orWhere($field, 'like', '%'.$data['search'].'%');
                        }
                    }
                });
            })
            // Determine if the request has specified sorting else use sort by latest
            ->when(isset($data['sort_by']), function ($q) use ($data) {
                $q->orderBy($data['sort_by'], $data['sort_desc'] ? 'desc' : 'asc');
            }, function ($q) {
                $q->latest();
            });

            return $items;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Apply Order By method.
     *
     * @param array $data = []
     * @return query
     */
    public function sortBy(array $data = [])
    {
        try {
            $items = $this->model
            // Determine if the request has specified sorting else use sort by latest
            ->when(isset($data['sort_by']), function ($q) use ($data) {
                $q->orderBy($data['sort_by'], $data['sort_desc'] ? 'desc' : 'asc');
            }, function ($q) {
                $q->latest();
            });

            return $items;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Get all listing of the resource.
     *
     * @return array
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Find specified resource.
     *
     * @param $id
     * @return found resource
     */
    public function show($id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Count all resource.
     *
     * @return int
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * Store newly created resource in storage.
     *
     * @param array $data
     * @return resource
     */
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Store many newly created resource in storage
     * Note : using this method in storing will not automatically store created_at.
     *
     * @param array $data
     * @return array of resource
     */
    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * Store newly created resource or return the first resource that matches the $matching_fields parameter.
     *
     * @param array $matching_fields
     * @param array $extra_data = []
     * @return resource
     */
    public function fc(array $matching_fields, array $extra_data = [])
    {
        return $this->model->firstOrCreate($matching_fields, $extra_data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return resource
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Display the specified resource and throw error if not found.
     *
     * @param int $id
     * @return resource
     */
    public function ff(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Update the specified resource.
     *
     * @param array $data
     * @param int $id
     * @return resource
     */
    public function update(array $data, $id)
    {
        $item = $this->model->findOrFail($id);
        $item->update($data);

        return $item;
    }

    /**
     * Remove the specified resource from storage by ID.
     *
     * @param int $id
     * @return resource
     */
    public function destroy(int $id)
    {
        $item = $this->find($id);
        $item->delete();

        return $item;
    }

    /**
     * Remove the specified resource from storage by UUID.
     *
     * @param string $uuid
     * @return resource
     */
    public function destroyByUuid(string $uuid)
    {
        $item = $this->findByUuid($uuid);
        $item->delete();

        return $item;
    }

    /**
     * Get the Initialized Model.
     *
     * @return model
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * Get the Initialized Model Table.
     *
     * @return model's table
     */
    public function table()
    {
        return $this->model->getTable();
    }

    /**
     * Display the specified resource.
     *
     * @param string $uuid
     * @return resource
     */
    public function findByUuid(string $uuid)
    {
        return $this->model->where('uuid', $uuid)->first();
    }
}
