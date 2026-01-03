<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image_url',
        'images',
        'ingredients',
        'skin_type',
        'benefits',
        'directions',
        'external_url',
        'external_urls',
        'features',
        'retailer_names',
        'retailer_logos',
    ];

    protected $casts = [
        'images' => 'array',
        'external_urls' => 'array',
        'retailer_names' => 'array',
        'retailer_logos' => 'array',
        'features' => 'array',
        'price' => 'decimal:2',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get all images (new images array + legacy image_url)
     */
    public function getAllImages(): array
    {
        $images = $this->images ?? [];
        if ($this->image_url && !in_array($this->image_url, $images)) {
            array_unshift($images, $this->image_url);
        }
        return $images;
    }

    /**
     * Get retailer logos
     */
    public function getRetailerLogos(): array
    {
        return $this->retailer_logos ?? [];
    }

    /**
     * Get the primary image (first image from the array)
     */
    public function getPrimaryImage(): ?string
    {
        $images = $this->getAllImages();
        return count($images) > 0 ? $images[0] : null;
    }

    /**
     * Get all external URLs
     */
    public function getAllExternalUrls(): array
    {
        $urls = $this->external_urls ?? [];
        if ($this->external_url && !in_array($this->external_url, $urls)) {
            array_unshift($urls, $this->external_url);
        }
        return array_filter($urls);
    }
}
