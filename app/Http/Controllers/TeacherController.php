<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function index($id=null)
    {
        try {
            if ($id == '') {
                $teacher = Teacher::get();
                return response([
                    'data' => $teacher,
                    'message' => 'Success',
                ]);
            } else {
                $teacher = Teacher::findOrFail($id);
                return response([
                    'data' => $teacher,
                    'message' => 'Success',
                ]);
            }
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ]);
        };
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'title' => 'required',
            'institute' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'message' => $validator->errors()->all(),
            ]);
        }

        try {
            $teacher = new Teacher();
            $teacher->name = $request->name;
            $teacher->title = $request->title;
            $teacher->institute = $request->institute;
            $teacher->save();
            return response([
                'message' => 'Teacher saved successfully',
                'teacher' => $teacher,
            ]);
        } catch (\Throwable$th) {
            return response([
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function storeMulti(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teachers.*.name' => 'required',
            'teachers.*.title' => 'required',
            'teachers.*.institute' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'message' => $validator->errors()->all(),
            ]);
        }

        try {
            $data = $request->all();
            foreach ($data['teachers'] as $addteacher) {
                $teacher = new Teacher();
                $teacher->name = $addteacher['name'];
                $teacher->title = $addteacher['title'];
                $teacher->institute = $addteacher['institute'];
                $teacher->save();
                return response([
                    'message' => 'Teacher saved successfully',
                    'teacher' => $teacher,
                ]);
            }
        } catch (\Throwable$th) {
            return response([
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '-' . $file->getClientOriginalExtension();
                $file->move(public_path('upload'), $fileName);
                return response([
                    'message' => 'Image uploaded successfully',
                    'file' => $fileName,
                ]);
            } else {
                return response([
                    'message' => 'File not found',
                ]);
            }
        } catch (\Throwable$th) {
            return response([
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
            $teacher->name = $request->name;
            $teacher->title = $request->title;
            $teacher->institute = $request->institute;
            $teacher->update();
            return response([
                'message' => 'Teacher updated successfully',
                'teacher' => $teacher,
            ]);
        } catch (\Throwable$th) {
            return response([
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $header = $request->header('Authorization');
            if ($header == '') {
                return response([
                    'message' => 'Authorization Required',
                ]);
            } else {
                if ($header == 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkiLCJuYW1lIjoiVXRzYWIgRGV5IiwiaWF0IjoxNTE2MjM5MDIyfQ.miJdB3rMGLLI7oeE_L9eJziBEPyGypLyoGthjWFPQjA') {
                    Teacher::findOrFail($id)->delete();
                    return response([
                        'message' => 'Teacher deleted successfully',
                    ]);
                } else {
                    return response([
                        'message' => 'Authorization does not match',
                    ]);
                }
            }
            
        } catch (\Throwable$th) {
            return response([
                'message' => $th->getMessage(),
            ]);
        }
    }
}
