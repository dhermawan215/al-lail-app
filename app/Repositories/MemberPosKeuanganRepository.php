<?php

namespace App\Repositories;

use App\Models\FinancialPost;

class MemberPosKeuanganRepository
{
    /**
     * reposiitory for pos keuangan management by members
     */
    public function saveData($data)
    {
        $financialPost = FinancialPost::create([
            'post_name' => $data['post_name'],
            'masjid_id' => $data['masjid_id'],
            'created_by' => $data['created_by'],
        ]);
        return $financialPost;
    }
    /**
     * delete data from database 
     * @param array
     */
    public function deleteData($id)
    {
        $query = FinancialPost::whereIn('id', $id)->delete();
    }
    /**
     * find single data
     */
    public function findSingleData($id)
    {
        return FinancialPost::find($id);
    }
    /**
     * update single data
     * @param array
     */
    public function updateSingleData($data)
    {
        $query = self::findSingleData($data['id']);
        $query->update([
            'post_name' => $data['post_name'],
        ]);
    }
}
