<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Services\Service;
use App\Helpers\ArrayHelper;
use Spatie\Permission\Models\Role;

class UserService extends Service
{
     /**
     * Get a listing of the resource.
     *
     * @param array $data
     * @return collection
     */
    public function index(array $data)
    {
        try {
            $items = Service::index($data);
            // Paginate if $data has page index and not null else not paginate
            $items = isset($data['page']) ? $items->paginate($data['limit']) : $items->get();
            return $items;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Create new user
     * @param array
     * @return item
     */
    public function store(array $data)
    {
        try {

            $item = Service::store($data);
            return $item;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show a user.
     * @param id
     * @return resource
     */
    public function show($id)
    {
        try {
           return Service::ff($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

     /**
     * Update new user.
     * @param id
     * @param array
     * @return resource
     */
    public function update(array $data, $id)
    {
        try {
            $item = Service::update($data, $id);
            return $item;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Soft Delete the user
     *
     * @param  int  $id
     * @return resource
     */
    public function destroy($id)
    {
        try {
            return Service::destroy($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    /**
     * Find user by username
     * 
     * @param string $username
     * @return resource
     */
    public function findByEmail(string $email)
    {
        try {
            return Service::where('email', $email)
                ->first();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}