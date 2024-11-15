<?php

namespace App\Livewire\Forms;

use App\Models\DoctorSpecialization;
use Livewire\Attributes\Validate;
use Livewire\Form;

class DoctorSpecializationPostForm extends Form
{
    #[Validate(['required', 'min: 3', 'max:40', 'unique:doctor_specializations,name'])]
    public $specialization_name = '';

    #[Validate(['required', 'min: 3'])]
    public $specialization_description = '';

    public function store(){
        $this->validate();

        DoctorSpecialization::create([
                'name' => $this->specialization_name,
                'description' => $this->specialization_description
            ]
        );

        $this->reset(['specialization_name', 'specialization_description']);
    }
}
