<?php

namespace App\Http\Controllers;

use App\Media;
use App\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
    public function index()
    {
        $scheduled = Schedule::withCount('media')
            ->orderBy('date','asc')
            ->orderBy('time','asc')
            ->paginate(30);
        return view('schedule.index',compact('scheduled'));
    }

    public function create()
    {
        return view('schedule.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'time' => 'required',
            'text' => 'required',
            'media.*' => 'sometimes|file|mimes:jpg,png,gif,mp4',
        ]);

        $schedule = Schedule::create($request->only(['date', 'time', 'text']));

        if ($request->media) {
            foreach ($request->media as $media) {
                $media = Storage::disk('public')->putFile('media', $media);
                $schedule->media()->create([
                    'file_name' => (string)$media,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Schedule tweet is set.');
    }

    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('schedule.edit',compact('schedule'));
    }


    public function show($id)
    {
        $schedule = Schedule::with('media')->findOrFail($id);
        return view('schedule.edit',compact('schedule'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'required',
            'time' => 'required',
            'text' => 'required',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->date = $request->date;
        $schedule->time = $request->time;
        $schedule->text = $request->text;
        $schedule->save();

        if ($request->media) {
            $media = Storage::disk('public')->putFile('media', $request->file('media'));
            $schedule->media()->create([
                'file_name' => (string)$media,
            ]);
        }

        return redirect()->back()->with('success', 'Schedule tweet is updated.');
    }

    public function status($id)
    {
        $schedule = Schedule::findOrFail($id);
        if ($schedule->disable){
            $schedule->disable = false;
        }
        else {
            $schedule->disable = true;
        }
        $schedule->save();
        return redirect()->to('/schedule');
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);

        foreach ($schedule->media as $media) {
            Storage::disk('public')->delete($media->file_name);
        }

        $schedule->delete();
        return redirect()->to('/schedule')->with('success', 'Scheduled tweet has been deleted.');
    }

    public function deleteMedia($media)
    {
        $media = Media::findOrFail($media);
        Storage::disk('public')->delete($media->file_name);
        $media->delete();
        return redirect()->to('/schedule/'.$media->schedule_id.'/edit')->with('success', 'Media has been deleted.');


    }
}
