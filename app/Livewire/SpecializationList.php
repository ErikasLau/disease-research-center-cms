<?php

namespace App\Livewire;

use App\Models\DoctorSpecialization;
use Livewire\Attributes\On;
use Livewire\Component;

class SpecializationList extends Component
{
    public $specializations;
    public $selectedSpecialization;

    public function mount()
    {
        $this->specializations = DoctorSpecialization::all();
    }

    #[On('specialization-added')]
    public function updateList()
    {
        $this->specializations = DoctorSpecialization::all();
    }

    public function render()
    {
        return view('livewire.specialization-list');
    }
}
