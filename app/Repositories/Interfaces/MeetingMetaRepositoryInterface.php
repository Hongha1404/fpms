<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface MeetingMetaRepositoryInterface extends BaseRepositoryInterface
{
    public function updateMeetingTime($id, $data);

    public function getMeetingAttendees($id);

    public function getMeetingTime($id);

    public function updateMeetingAttendees($id, $data);
}
