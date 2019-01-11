<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\MeetingRequestUpdate;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ReleaseRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\SprintRepositoryInterface;
use App\Repositories\Interfaces\MeetingRepositoryInterface;
use App\Repositories\Interfaces\MeetingTypeRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\MeetingMetaRepositoryInterface;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
{
    protected $meeting;
    protected $user;
    protected $meetingMeta;
    protected $project;
    protected $sprint;
    protected $release;
    protected $meetingType;

    public function __construct(
        ReleaseRepositoryInterface $release,
        SprintRepositoryInterface $sprint,
        ProjectRepositoryInterface $project,
        MeetingRepositoryInterface $meeting,
        MeetingTypeRepositoryInterface $meetingType,
        UserRepositoryInterface $user,
        MeetingMetaRepositoryInterface $meetingMeta
    ) {
        $this->release = $release;
        $this->sprint = $sprint;
        $this->project = $project;
        $this->meeting = $meeting;
        $this->meetingType = $meetingType;
        $this->user = $user;
        $this->meetingMeta = $meetingMeta;
    }

    public function index()
    {
        $meetings = $this->meeting->all();

        return view('meeting.index', compact('meetings'));
    }

    public function create()
    {
        $meetingTypes = $this->meetingType->all();
        $sprints = $this->sprint->all();
        $users = $this->user->all();

        return view('meeting.create', compact('meetingTypes', 'sprints', 'users'));
    }

    public function ajaxGetUser($id)
    {
        $sprint = $this->sprint->find($id);
        $users = $sprint->release->project->users;

        return response()->json($users);
    }

    public function store(MeetingRequestUpdate $request)
    {
        $data = [
            'name' => $request->name,
            'sprint_id' => $request->sprint,
            'meeting_type_id' => $request->meeting_type,
            'location' => $request->location,
            'hosting_by' => $request->hosting,
            'time_keeper' => $request->time_keeper,
        ];

        $meetingTime = [
            'date' => $request->date,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
        ];
        $attendees = $request->attendees;
        $project = $this->sprint->find($request->sprint)->release->project;
        $attendeeData = [];

        foreach ($attendees as $attendee) {
            $positions = DB::table('project_user')
            ->join('positions', 'project_user.position_id', '=', 'positions.id')
            ->where(['project_user.user_id' => $attendee, 'project_user.project_id' => $project->id])
            ->get();
            $user = $this->user->find($attendee);
            $userMeta = [
                $user->name => json_encode($positions->pluck('name')),
            ];
            $attendeeData = array_merge($attendeeData, $userMeta);
        }

        $meeting = $this->meeting->store($data);

        $meetingAttendeesMeta = [
            'meeting_id' => $meeting->id,
            'meeting_key' => 'meeting_attendees',
            'meeting_value' => '[' . json_encode($attendeeData) . ']',
        ];
        $meetingTimeMeta = [
            'meeting_id' => $meeting->id,
            'meeting_key' => 'meeting_time',
            'meeting_value' => '[' . json_encode($meetingTime) . ']',
        ];

        $this->meetingMeta->store($meetingAttendeesMeta);
        $this->meetingMeta->store($meetingTimeMeta);

        Toastr::success(__('created'), 'Success');
        
        return redirect()->route('user.meeting.index');
    }

    public function edit($id)
    {
        $meetingTypes = $this->meetingType->all();
        $meetingAttendees = $this->meetingMeta->getMeetingAttendees($id);
        $attendees = $meetingAttendees->meeting_value;
        $meetingTime = $this->meetingMeta->getMeetingTime($id);
        $meeting = $this->meeting->find($id);
        $sprints = $this->sprint->getSprintOnProject($id);
        $users = $meeting->sprint->release->project->users;

        return view('meeting.edit', compact('sprints', 'meeting', 'meetingTypes', 'users', 'attendees'))->with(['meetingTime' => json_decode($meetingTime, true)]);
    }

    public function update(MeetingRequestUpdate $request, $id)
    {
        $data = [
            'name' => $request->name,
            'sprint_id' => $request->sprint,
            'meeting_type_id' => $request->meeting_type,
            'location' => $request->location,
            'hosting_by' => $request->hosting,
            'time_keeper' => $request->time_keeper,
        ];

        $meetingTime = [
            'date' => $request->date,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
        ];

        $attendees = $request->attendees;
        $project = $this->sprint->find($request->sprint)->release->project;
        $attendeeData = [];

        foreach ($attendees as $attendee) {
            $positions = DB::table('project_user')
                ->join('positions', 'project_user.position_id', '=', 'positions.id')
                ->where(['project_user.user_id' => $attendee, 'project_user.project_id' => $project->id])
                ->get();
            $user = $this->user->find($attendee);
            $userMeta = [
                $user->name => json_encode($positions->pluck('name')),
            ];
            $attendeeData = array_merge($attendeeData, $userMeta);
        }

        $meeting = $this->meeting->update($id, $data);

        $meetingAttendeesMeta = [
            'meeting_id' => $meeting->id,
            'meeting_key' => 'meeting_attendees',
            'meeting_value' => '[' . json_encode($attendeeData) . ']',
        ];
        $meetingTimeMeta = [
            'meeting_id' => $meeting->id,
            'meeting_key' => 'meeting_time',
            'meeting_value' => '[' . json_encode($meetingTime) . ']',
        ];
        $this->meetingMeta->updateMeetingAttendees($id, $meetingAttendeesMeta);

        $this->meetingMeta->updateMeetingTime($id, $meetingTimeMeta);

        Toastr::success(__('updated'), 'Success');

        return redirect()->route('user.meeting.index');
    }
}
