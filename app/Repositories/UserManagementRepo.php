<?php

namespace App\Repositories;

use App\Models\User;

class UserManagementRepo
{
    /**
     * method for find single for, for update/edit
     * @param int id
     * @return eloquent
     */
    public function findData($id)
    {
        $user = User::find($id);
        return $user;
    }
    /**
     * method for change activation user
     * @param array data
     */
    public function changeActive($data): void
    {
        $active = self::findData($data['id']);
        $active->update([
            'is_active' => $data['active'],
        ]);
    }
}
