<?php

namespace App\Repositories;

use App\Models\Transaction;

class ReportRepository
{
    /**
     * save data report
     */
    public function saveReport($data)
    {
        $query = Transaction::create([
            'category_id' => $data['category'],
            'financial_post_id' => $data['financial'],
            'masjid_id' => $data['masjid'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'transaction_date' => $data['transaction_date'],
            'created_by' => $data['created'],
        ]);

        return $query;
    }
    /**
     * get single data for edit
     */
    public function getSingleData($id)
    {
        return Transaction::find($id);
    }
    /**
     * update single data
     * @param $query get from getSingleData
     */
    public function updateSingleReport($query, $data): void
    {
        $query->update($data);
    }
}
