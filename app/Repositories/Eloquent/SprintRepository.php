<?php

namespace App\Repositories\Eloquent;

use App\Models\Meeting;
use App\Models\Sprint;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\SprintRepositoryInterface;

class SprintRepository extends BaseRepository implements SprintRepositoryInterface
{
    protected $model;

    /**
     * ProjectsRepository constructor.
     * @param Project $article
     */
    public function __construct(Sprint $sprint)
    {
        $this->model = $sprint;
    }

    public function getSprintOnProject($id)
    {
        $meeting = Meeting::findOrFail($id);
        $sprints = $meeting->sprint;
        $release_id = $sprints->release->id;
        $sprints = Sprint::where('release_plan_id', $release_id)->get();

        return $sprints;
    }
}
