<?php

namespace App\Filament\Widgets;

trait ListensForStatusFilter
{
    public $statusFilter = null;

    public function getListeners()
    {
        return [
            'statusFilterSelected' => 'setStatusFilter',
        ];
    }

    public function setStatusFilter($status)
    {
        $this->statusFilter = $status;
        $this->dispatchBrowserEvent('apexchart-refresh-' . $this->getChartId());
    }

    public function clearStatusFilter()
    {
        $this->statusFilter = null;
        $this->dispatchBrowserEvent('apexchart-refresh-' . $this->getChartId());
    }
}