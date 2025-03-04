<?php

namespace App\Repositories\interfaces;

interface RepositoryInterface
{
    //to perfom finding single data
    public function findData($id);
    /**
     * to perform save data
     */
    public function saveData($data);
    /**
     * to perform update single data
     */
    public function updateData($data);
}
