<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class JsonDataStore
{
    protected $dataPath;
    protected $cacheMinutes = 60;

    public function __construct()
    {
        $this->dataPath = storage_path('data');
        
        // Create data directory if not exists
        if (!File::exists($this->dataPath)) {
            File::makeDirectory($this->dataPath, 0755, true);
        }
    }

    /**
     * Get all records from a JSON file
     */
    public function all(string $collection): array
    {
        $cacheKey = "json_data_{$collection}";
        
        return Cache::remember($cacheKey, $this->cacheMinutes, function () use ($collection) {
            $filePath = $this->getFilePath($collection);
            
            if (!File::exists($filePath)) {
                return [];
            }
            
            $content = File::get($filePath);
            $data = json_decode($content, true);
            
            return is_array($data) ? $data : [];
        });
    }

    /**
     * Find a single record by ID
     */
    public function find(string $collection, $id): ?array
    {
        $items = $this->all($collection);
        
        foreach ($items as $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                return $item;
            }
        }
        
        return null;
    }

    /**
     * Find by a specific field
     */
    public function findBy(string $collection, string $field, $value): ?array
    {
        $items = $this->all($collection);
        
        foreach ($items as $item) {
            if (isset($item[$field]) && $item[$field] == $value) {
                return $item;
            }
        }
        
        return null;
    }

    /**
     * Get multiple records by field value
     */
    public function getBy(string $collection, string $field, $value): array
    {
        return $this->getByField($collection, $field, $value);
    }

    /**
     * Get multiple records by field value (alias for getBy)
     */
    public function getByField(string $collection, string $field, $value): array
    {
        $items = $this->all($collection);
        $results = [];
        
        foreach ($items as $item) {
            if (isset($item[$field]) && $item[$field] == $value) {
                $results[] = $item;
            }
        }
        
        return $results;
    }

    /**
     * Find by two fields (AND condition)
     */
    public function findByTwoFields(string $collection, string $field1, $value1, string $field2, $value2): ?array
    {
        $items = $this->all($collection);
        
        foreach ($items as $item) {
            if (isset($item[$field1]) && $item[$field1] == $value1 &&
                isset($item[$field2]) && $item[$field2] == $value2) {
                return $item;
            }
        }
        
        return null;
    }

    /**
     * Create a new record
     */
    public function create(string $collection, array $data): array
    {
        $items = $this->all($collection);
        
        // Generate ID
        $maxId = 0;
        foreach ($items as $item) {
            if (isset($item['id']) && $item['id'] > $maxId) {
                $maxId = $item['id'];
            }
        }
        $data['id'] = $maxId + 1;
        $data['created_at'] = now()->toISOString();
        $data['updated_at'] = now()->toISOString();
        
        $items[] = $data;
        
        $this->save($collection, $items);
        $this->clearCache($collection);
        
        return $data;
    }

    /**
     * Update a record
     */
    public function update(string $collection, $id, array $data): ?array
    {
        $items = $this->all($collection);
        
        foreach ($items as $index => $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                $data['id'] = $id;
                $data['updated_at'] = now()->toISOString();
                // Preserve created_at
                $data['created_at'] = $item['created_at'] ?? now()->toISOString();
                
                $items[$index] = array_merge($item, $data);
                
                $this->save($collection, $items);
                $this->clearCache($collection);
                
                return $items[$index];
            }
        }
        
        return null;
    }

    /**
     * Delete a record
     */
    public function delete(string $collection, $id): bool
    {
        $items = $this->all($collection);
        
        foreach ($items as $index => $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                unset($items[$index]);
                
                // Reindex array
                $items = array_values($items);
                
                $this->save($collection, $items);
                $this->clearCache($collection);
                
                return true;
            }
        }
        
        return false;
    }

    /**
     * Save data to file
     */
    protected function save(string $collection, array $data): bool
    {
        $filePath = $this->getFilePath($collection);
        
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        return File::put($filePath, $json) !== false;
    }

    /**
     * Get file path for a collection
     */
    protected function getFilePath(string $collection): string
    {
        return $this->dataPath . "/{$collection}.json";
    }

    /**
     * Clear cache for a collection
     */
    public function clearCache(string $collection): void
    {
        Cache::forget("json_data_{$collection}");
    }

    /**
     * Initialize with seed data if file doesn't exist
     */
    public function initIfEmpty(string $collection, array $seedData): void
    {
        $filePath = $this->getFilePath($collection);
        
        if (!File::exists($filePath) || empty($this->all($collection))) {
            $this->save($collection, $seedData);
            $this->clearCache($collection);
        }
    }

    /**
     * Count records
     */
    public function count(string $collection): int
    {
        return count($this->all($collection));
    }

    /**
     * Check if collection has data
     */
    public function exists(string $collection): bool
    {
        return $this->count($collection) > 0;
    }
}

