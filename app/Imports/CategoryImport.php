<?php

namespace App\Imports;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;


class CategoryImport implements ToModel, WithValidation, WithHeadingRow
{
    public function model(array $row)
    {
        // Log the row data for debugging
        Log::info('Row data:', $row);
        $row = array_change_key_case($row, CASE_LOWER);
    
        // Check if the category name exists in the database
        if (!Category::where('name', $row['name'])->exists()) {
            // Create the Category if it doesn't exist
            return new Category([
                'name' => $row['name'],
                'description' => isset($row['description']) ? (string) $row['description'] : '', // Ensure it's a string
                'image' => isset($row['image']) ? (string) $row['image'] : '', // Ensure it's a string
            ]);
        }
    
        // Return null if it's a duplicate category
        return null;
    }
    

    // Validation rules for the Excel import
    public function rules(): array
    {
        return [
            'name' => 'required', // Only require name; don't enforce uniqueness here
        ];
    }

    // Optionally, you can add a custom message for validation failures
    public function customValidationMessages()
    {
        return [
            'name.required' => 'The category name is required.',
        ];
    }
}
