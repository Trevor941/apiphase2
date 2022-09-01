<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
   public function createProject(Request $request){

      $request->validate([
         "name" => "required",
         "description" => "required",
         "duration" => "required",
     ]);
        $student_id = auth()->user()->id;
        $project = new Project();

        $project->name = $request->name;
        $project->student_id = $student_id;
        $project->description = $request->description;
        $project->duration = $request->duration;
        $project->save();

        // send response
        return response()->json([
            "status" => 1,
            "message" => "projected created successfully",
            "data" => $project
        ]);

   }

   public function listProjects(){
      
      $student_id = auth()->user()->id;
      $projects = Project::where("student_id", $student_id)->get();
      return response()->json([
         "status" => 1,
         "message" => "list of projects displayed successfully",
         "data" => $projects
     ]);

   }

   public function singleProject($id){
      
      $student_id = auth()->user()->id;
      if(Project::where(["id"=>$id, "student_id"=>$student_id])){
         $project_details = Project::where(["id"=>$id, "student_id"=>$student_id])->first();

         return response()->json([
            "status" => 1,
            "message" => "project details successfully listed",
            "data" => $project_details
        ]);
      }
      else{
         return response()->json([
            "status" => 0,
            "message" => "project not found",
            "data" => $project_details
        ]);
      }

   }

   public function deleteProject($id){
      $student_id = auth()->user()->id;
      if(Project::where(["id"=>$id, "student_id"=>$student_id])){
         $project = Project::where(["id"=>$id, "student_id"=>$student_id])->first();
         $project->delete();

         return response()->json([
            "status" => 1,
            "message" => "project deleted successfully",
        ]);
      }
      else{
         return response()->json([
            "status" => 0,
            "message" => "project not found",
        ]);
      }
   }
 
}
