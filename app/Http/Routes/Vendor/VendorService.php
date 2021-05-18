<?php

namespace App\Http\Routes\Vendor;

use App\Http\Models\Image;
use App\Http\Routes\Product\Models\Product;
use App\Http\Routes\Product\ProductRepository;
use App\Http\Routes\Vendor\Models\Vendor;
use App\Utils\AuthUtils;
use App\Utils\ImageUtils;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class VendorService {
    private $vendorRepository;
    private $productRepository;
    private $image;
    private $vendorImagesRepository;

    public function __construct(VendorRepository $vendorRepository, ProductRepository $productRepository,
                                VendorImagesRepository $vendorImagesRepository, Image $image) {
        $this->vendorRepository = $vendorRepository;
        $this->productRepository = $productRepository;
        $this->vendorImagesRepository = $vendorImagesRepository;
        $this->image = $image;
    }

    public function getActive($locationId) {
        if ($locationId) {
            $vendors = $this->vendorRepository->findByLocationId($locationId);
        } else {
            $vendors = $this->vendorRepository->findActive();
        }
        return $vendors;
    }
    
    public function getAll() {
       return $this->vendorRepository->findAll();
    }    
    
    public function getAllByQuery($query) {
       return $this->vendorRepository->findByQuery($query);
    }

    public function getPopular() {
        return Cache::remember('vendors.popular', config('cache.expiry_time'), function () {
            return Vendor::mapArrayToDto($this->vendorRepository->findPopular());
        });
    }

    public function getLatest() {
        return Cache::remember('vendors.latest', config('cache.expiry_time'), function () {
            return Vendor::mapArrayToDto($this->vendorRepository->findLatest());
        });
    }

    public function getById($id) {
        return Vendor::fromEntity($this->vendorRepository->findById($id));
    }

    public function getProducts($id) {
        return $this->productRepository->findByVendorId($id);
    }

    public function addVendorImages($vendorId, $images) {
        foreach ($images['images'] as $image) {
            $path = Storage::disk('s3')->put('images/vendors', $image
                ->manipulate(function (\Intervention\Image\Image $image) {
                    $image->fit(600, 600);
                }));
            $image_id = $this->image->create(['size' => $image->getClientSize(), 'path' => $path])->id;
            $this->vendorImagesRepository->create(['vendor_id' => $vendorId, 'image_id' => $image_id]);
        }
        return $this->vendorRepository->findById($vendorId);
    }

    public function updateVendorDetails($vendorId, $vendorDetails) {
        if (array_key_exists('certificate', $vendorDetails) && $vendorDetails['certificate']) {
            $path = Storage::disk('s3')->put('images/vendors/certificates', $vendorDetails['certificate']);
            $vendorDetails['certificate'] = $path;
            logger(print_r($vendorDetails, true));
        }

        return $this->vendorRepository->update($vendorId, $vendorDetails);
    }

    public function deleteVendorImage($vendorId, $imageId) {
        $vendorImage = $this->vendorImagesRepository->findByImageIdAndVendorId($vendorId, $imageId);
        Storage::disk('s3')->delete($vendorImage->toArray()['image']['path']);
        $vendorImage->delete();
        return true;
    }
}