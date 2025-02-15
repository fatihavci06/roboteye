<?php

namespace App\Services;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Class CompanyService
 * @package App\Services
 */
class CompanyService
{
    /**
     * Yeni bir çalışan oluştur.
     *
     * @param array $data
     * @return Company
     */
    public static function create($data): Company
    {
        if (isset($data['logo']) && $data['logo']->isValid()) {
            // Dosyayı 'public' diskine yükle
            $filePath = $data['logo']->store('uploads', 'public');
            
            // Yüklenen dosyanın yolunu veriye ekle
            $data['logo'] = $filePath;
        } else {
            // Logo yüklenmemişse, varsayılan bir logo dosyası kullanabilirsiniz
            $data['logo'] = 'default_logo.png'; // Varsayılan logo
        }
    
        // Şirket verilerini kaydet ve döndür
        return Company::create($data);
    
        
    }
    /**
     * 
     * @param int $perPage Sayfa başına gösterilecek şirket sayısı (varsayılan: 15)
     */
    public function list()  
    {
      
       return Company::paginate(15);  
        // CompanyResource ile sararak dönüş
        // return CompanyResource::collection($companies);
    }
}
