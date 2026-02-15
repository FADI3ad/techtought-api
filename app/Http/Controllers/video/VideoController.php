<?php

namespace App\Http\Controllers\video;
use App\Models\Video;
use App\Http\Controllers\Controller;
use App\Http\Requests\video\UpdateVideoRequest;
use Illuminate\Http\Request;

class VideoController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
             $videos = Video::all();
        return response()->json($videos);
    }

        /**
     * Store video.
     */
    public function store(Request $request)
    {
        $title = $request->input('title');
        $lessonId = $request->input('lesson_id');
        $duration = $request->input('duration');


        $video = Video::create($request->validated());

          return response()->json([
            'status' => 'success',
            'message' => 'video created successfully',
            'data'=>[
                  "vedio" => [
                  "id"=>$video->id,
                  "title"=> $video->title,
                  "duration"=>$video->duration,
                  "current_time"=>$video->current_time

                  ]
                ] 
           ],status: 201);
     
    }

        /**
     * Display video
     */
    public function show( video $video)
    {
                   return response()->json([
            'status' => 'success',
            'message' => 'video retrieved successfully',
            'data'=>[
                  "vedio" => [
                  "id"=>$video->id,
                  "title"=> $video->title,
                  "duration"=>$video->duration,
                  "current_time"=>$video->current_time

                  ]
                ] 
           ],status: 200);
         
    }

        /**
     * Update video.
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {
         
        $video->update($request->validated());

         return response()->json([
            'status' => 'success',
            'message' => 'video updated successfully',
            'data'=>[
                  "vedio" => [
                  "id"=>$video->id,
                  "title"=> $video->title,
                  "duration"=>$video->duration,
                  "current_time"=>$video->current_time

                  ]
                ] 
           ],status: 200);
    }

    /**
     * Remove video.
     */
    public function destroy(string $id)
    {
           $video = video::findOrFail($id);
        $video->delete();

         return response()->json([
            'status' => 'success',
            'message' => 'Deleted successfully'
            ],status: 200);
    }

}
