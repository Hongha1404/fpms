<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface SprintRepositoryInterface extends BaseRepositoryInterface
{
    public function getSprintOnProject($id);
}
