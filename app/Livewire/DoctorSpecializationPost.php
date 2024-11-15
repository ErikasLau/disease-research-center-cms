<?php

namespace App\Livewire;

use App\Livewire\Forms\DoctorSpecializationPostForm;
use App\Models\DoctorSpecialization;
use Livewire\Component;

class DoctorSpecializationPost extends Component
{
    public DoctorSpecializationPostForm $form;

    public function save()
    {
        $this->form->store();

        return $this->dispatch('specialization-added');
    }

    public function render()
    {
        return view('livewire.create-doctor-specialization');
    }
}
