<?php

namespace App\Repositories;

use App\Models\Masjid;
use App\Repositories\interfaces\RepositoryInterface;

class MasjidManagementRepository implements RepositoryInterface
{
    /**
     * find the single data
     * @param id
     * @return eloquent
     */
    public function findData($id)
    {
        return Masjid::find($id);
    }

    public function saveData($data) {}

    public function updateData($data) {}

    public function verifiedMasjid($data): void
    {
        $masjid = self::findData($data['id']);
        $masjid->update([
            'verification_status' => 1
        ]);
    }

    public function getDetailMasjid($id)
    {
        $masjid = Masjid::with('masjidToUsers:id,name,email')->where('id', $id)->first();
        return $masjid;
    }
}
