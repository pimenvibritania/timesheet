<?php

namespace App\Exports;

use App\Models\Sprint;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SprintExport implements FromCollection
{

    public function __construct(
        private int $sprintId
    )
    {

    }
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Sprint::find($this->sprintId);
    }
}
