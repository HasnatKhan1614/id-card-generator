<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
     * Map each row to the Student model.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Check for duplicate email
        if (Student::where('sid', $row['sid'] ?? '')->exists()) {
            throw new \Exception("Duplicate Student Id found: " . ($row['sid'] ?? ''));
        }

        // Create a new Student instance with nullable fields
        return new Student([
            'campus'  => $row['campus'] ?? null,
            'sid'  => $row['sid'] ?? null,
            'class'  => $row['class'] ?? null,
            'student_name'  => $row['student_name'] ?? null,
            'first_name'  => $row['first_name'] ?? null,
            'last_name'  => $row['last_name'] ?? null,
            'father_name'  => $row['father_name'] ?? null,
            'phone'  => $row['phone'] ?? null,
            'dob'  => $row['dob'] ?? null,
            'address'  => $row['address'] ?? null,
        ]);
    }
}
