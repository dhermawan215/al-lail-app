<?php

namespace App\Repositories;

use App\Models\CategoryTransaction;
use App\Repositories\interfaces\RepositoryInterface;

class CategoryTransactionRepository implements RepositoryInterface
{
    /**
     * @param  id
     * @return eloquent
     */
    public function findData($id)
    {
        return CategoryTransaction::find($id);
    }
    /**
     * @param $data as request
     * @return eloquent
     */
    public function saveData($data)
    {
        $category = CategoryTransaction::create([
            'category_name' => $data->category_name,
        ]);

        return $category;
    }
    /**
     * update single data
     * @param data array
     */
    public function updateData($data): void
    {
        $category = self::findData($data['id']);
        $category->update([
            'category_name' => $data['category_name'],
        ]);
    }
    /**
     * method multiple delete data
     * @param array
     */
    public function deleteDatas($ids)
    {
        return CategoryTransaction::whereIn('id', $ids)->delete();
    }
}
