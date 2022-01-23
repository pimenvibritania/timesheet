<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class Export extends AbstractAction
{
    public function getTitle(): string
    {
        return 'Export';
    }

    public function getIcon(): string
    {
        return 'voyager-book-download';
    }

    public function getPolicy(): string
    {
        return 'read';
    }

    public function getAttributes(): array
    {
        return [
            'style' => "margin-right:5px",
            'class' => 'btn btn-sm btn-success pull-right',
        ];
    }

    public function getDefaultRoute(): string
    {
        return route('sprints.export',$this->data->{$this->data->getKeyName()} );
    }

    public function shouldActionDisplayOnDataType(): bool
    {
        return $this->dataType->slug == 'sprints';
    }
}
