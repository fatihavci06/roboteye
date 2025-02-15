<?php

namespace App\Services;

use App\Models\Employe;

/**
 * Class EmployeService
 * @package App\Services
 */
class EmployeService
{
    /**
     * Yeni bir çalışan oluştur.
     *
     * @param array $data
     * @return Employe
     */
    public static function create($data): Employe
    {
        return Employe::create($data);
    }
    /**
     * @param int $perPage Sayfa başına gösterilecek çalışan sayısı (varsayılan: 15)
     
     */
    public static function list(int $perPage = 15)
    {
        return Employe::with('company')->paginate($perPage);
    }
}
