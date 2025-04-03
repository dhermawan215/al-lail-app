<?php

namespace App\Repositories;

use App\Models\Masjid;

class MemberMasjidRepository
{
    /**
     * reposiitory for masjid management by members
     */
    public function saveData($data)
    {
        $query = Masjid::create([
            'name' => $data['name'],
            'masjid_code' => $data['masjid_code'],
            'slug' => $data['slug'],
            'address' => $data['address'],
            'phone_masjid' => $data['phone_masjid'],
            'image' => $data['image'],
            'verificaation_status' => 0,
            'registered_at' => $data['registered_at'],
        ]);
        return $query;
    }

    public function getDetailMasjid($id)
    {
        $masjid = Masjid::with('masjidToUsers')->where('id', $id)->first();
        return $masjid;
    }
    /**
     * find multiple data
     * @param array
     */
    public function findMultipleData($id)
    {
        return Masjid::whereIn('id', $id);
    }
    /**
     * delete multiple data
     * @param array
     */
    public function deleteMultipleData($id)
    {
        $query = self::findMultipleData($id);
        $query->delete();
    }
    /**
     * find data
     * @param id
     */
    public function findSingleData($id)
    {
        return Masjid::find($id);
    }
}
