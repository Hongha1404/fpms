<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ReleaseRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Http\Requests\ReleaseRequestStore;
use App\Http\Requests\ProjectRequestUpdate;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Http\File;
use App\Helper\FileHelper;
use Carbon\Carbon;

class ReleaseController extends Controller
{
    protected $release;

    public function __construct(ReleaseRepositoryInterface $release, UserRepositoryInterface $user, ProjectRepositoryInterface $project)
    {
        $this->release = $release;
        $this->user = $user;
        $this->project = $project;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $releases = $this->release->all();

        return view('release.index', compact('releases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = $this->user->getNormalUser(['id', 'name']);
        $project = $this->project->all();
        
        return view('release.create', compact('users', 'project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProjectRequestStore  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReleaseRequestStore $request)
    {
        $date = Carbon::parse($request->release_date);
        $data = [
            'project_id' => $request->project,
            'release_date' => $date,
            'goal' => $request->goal,
            'note' => $request->note,
            'version' => $request->version,
        ];
        $release = $this->release->store($data);

        Toastr::success(__('created'), 'Success');
        
        return redirect()->route('user.release.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $release = $this->release->find($id);

        return view('release.show', compact('release'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $release = $this->release->with('project')->find($id);
        $project = $this->project->all();
        
        return view('release.edit', compact('release', 'project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReleaseRequestStore $request, $id)
    {
        $release = $this->release->find($id);
        $date = Carbon::parse($request->release_date);
        $data = [
            'project_id' => $request->project,
            'release_date' => $date,
            'goal' => $request->goal,
            'note' => $request->note,
            'version' => $request->version,
        ];
        $release = $this->release->update($id, $data);

        Toastr::success(__('edited'), 'Success');
        
        return redirect()->route('user.release.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $release = $this->release->delete($id);

        Toastr::success(__('deleted'), 'Success');

        return redirect()->route('user.release.index');
    }
}
