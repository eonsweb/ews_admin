<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel, WithValidation, WithHeadingRow
{
    protected $errors = [];
    public function model(array $row)
    {
        //Change Heading row name to lowercase
        $row = array_change_key_case($row, CASE_LOWER);
        try{
            $name = $row['name'];
            $phone = isset($row['phone']) ? (string) $row['phone'] : '';
            $address = isset($row['address']) ? $row['address'] : '';
            $id_type = isset($row['id type']) ? $row['id type'] : '';
            $id_number = isset($row['id number']) ? $row['id number'] : '';

            $customer = Customer::updateOrCreate(
                ['name' => $name],
                [
                    'phone' => $phone,
                    'address' => $address,
                    'id_type' => $id_type,
                    'id_number' => $id_number
                ]
                );

        }
        catch(\Exception $e){
            $this->errors[0] = "Error with customer '{$row['name']}': ".$e->getMessage();
        }
        
    }

    public function getErrors()
    {
        return $this->errors;
    }

     // Validation rules for the Excel import
     public function rules(): array
     {
         return [
             'name' => 'required', // Only require name; don't enforce uniqueness here
         ];
     }
}
