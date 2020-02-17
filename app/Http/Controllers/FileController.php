<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Field;
use App\File;
use App\User;
use App\EditorFile;

class FileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->uploadedContaintValidator($request);
        DB::beginTransaction();
        $field = $this->getFieldObject($request->field);
        try {
            $path = Storage::putFile('public/files', $request->file('file'));
            File::create([
                'researcher_email' => $request->email,
                'original_name' => $request->file->getClientOriginalName(),
                'path' => $path,                
                'field_id' => $field->id,
            ]);
            $this->assagnEditors($path, $field);
            DB::commit();
            return redirect()->back()->with('status', 'success');
        }
        catch(\Exception $e) {
            DB::rollback();
            Storage::delete($path);
            return redirect()->back()->with('status', 'error');
        }
        
    }

    /**
     * validate uploaded file (file type, researcher email and field)
     */

    public function uploadedContaintValidator(Request $request)
    {
        $request->validate([
            "file" => "required|mimes:pdf|max:10000",
            'email' => 'required|email|string',
            'field' => 'required|string',
        ]);
    }

    //get field object
    public function getFieldObject($name)
    {
        return Field::whereName($name)->first();
    }

    //assign at most 3 editors randomly
    protected function assagnEditors($path , $field)
    {
        $file = File::wherePath($path)->first();        
        $totalUsers = $field->users()->count();
        $users = array();
        $index = 0;
        foreach ($field->users()->get() as $user) {
            $users[$index++] = $user->id;
        }
        $attachedUsers = array();
        if ($totalUsers > 3) {
            for ($count=0; $count < 3;) {
                $selectUser = rand(0, $totalUsers - 1);
                if($user = User::find($users[$selectUser]))
                {
                    if(!in_array($users[$selectUser], $attachedUsers))
                    {
                        $user->files()->attach($file->id);
                        $attachedUsers[$count] = $users[$selectUser];
                        $count++;
                    }
                }
            }
        } else {
            for ($count=0; $count < $totalUsers; $count++) {
                if($user = User::find($users[$count]))
                {
                    $user->files()->attach($file->id);
                }
            }
        }
    }
   
    //download file
    public function download(File $file)
    {
        $this->middleware('auth');
        if(\Gate::allows(['isEditor']))
        {
            DB::beginTransaction();
            try {
                auth()->user()->files()->whereFileId($file->id)->updateExistingPivot($file, array('seen' => true), false);
                if(Storage::disk('local')->exists($file->path))
                {
                    DB::commit();
                    return Storage::download($file->path, $file->original_name);
                }
                else {
                    DB::rollback();
                    return redirect()->back()->with('status', 'error');
                }
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('status', 'error');
            }
        }
    }

    public function createReply(File $file)
    {
        if (\Gate::authorize('isEditor')) {
            return view('editor.reply', compact('file'));
        }
    }

    public function storeReply(Request $request, File $file)
    {
        $request->validate([
            'file' => 'required|mimes:pdf',
        ]);
        DB::beginTransaction();
        try {
            $path = Storage::putFile('public/files/editors', $request->file('file'));
            File::create([
                'researcher_email' => 'user',
                'original_name' => $request->file->getClientOriginalName(),
                'path' => $path,                
                'field_id' => $file->field_id,
                'is_user' => true,
            ]);
            EditorFile::create([
                'user_id' => auth()->user()->id,
                'file_id' => $file->id,
            ]);
            auth()->user()->files()->whereFileId($file->id)->updateExistingPivot($file, array('seen' => true), false);
            auth()->user()->files()->whereFileId($file->id)->updateExistingPivot($file, array('replied' => true), false);
            DB::commit();
            return redirect('home');
        } catch (\Exception $e) {
            DB::rollback();
            Storage::delete($path);
            return redirect()->back()->with('status', 'error');
        }
    }


}
