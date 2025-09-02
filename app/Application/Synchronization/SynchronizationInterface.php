<?php

namespace App\Application\Synchronization;

interface SynchronizationInterface
{
    public function loadData(): array;
    public function appendData(array $data): void;
}
