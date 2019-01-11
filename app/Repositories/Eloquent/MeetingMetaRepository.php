<?php

namespace App\Repositories\Eloquent;

use App\Models\MeetingMeta;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\MeetingMetaRepositoryInterface;

class MeetingMetaRepository extends BaseRepository implements MeetingMetaRepositoryInterface
{
    protected $model;

    /**
     * ProjectsRepository constructor.
     * @param Project $article
     */
    public function __construct(MeetingMeta $meetingMeta)
    {
        $this->model = $meetingMeta;
    }

    public function getMeetingAttendees($id)
    {
        $meeting_attendees = $this->model->where('meeting_id', $id)->where('meeting_key', 'meeting_attendees')->first();

        return $meeting_attendees;
    }

    public function getMeetingTime($id)
    {
        $meeting_time = $this->model->where('meeting_id', $id)->where('meeting_key', 'meeting_time')->first();

        return $meeting_time;
    }

    public function updateMeetingAttendees($id, $data)
    {
        $meeting_meta = $this->model->where('meeting_id', $id)->where('meeting_key', 'meeting_attendees');

        return $meeting_meta->update($data);
    }

    public function updateMeetingTime($id, $data)
    {
        $meeting_meta = $this->model->where('meeting_id', $id)->where('meeting_key', 'meeting_time');

        return $meeting_meta->update($data);
    }
}
