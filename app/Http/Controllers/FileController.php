<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Storage;
class FileController extends Controller
{
    //
    public function index(){
        $file_data=FileUpload::get();
        return view('welcome',compact('file_data'));
    }
    public function upload(Request $request)
    {
        // Validate the request
        // $request->validate([
        //     'files' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // 2MB maximum size, adjust as needed
        // ]);
        // dd($request->all());
    
        foreach ($request->file('files') as $img) {
            // dd($img);
            $fileName = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
             $img->storeAs('uploads', $fileName); 
            FileUpload::create([
                'image' => $fileName,
            ]);
        }
    
        return redirect()->back()->with('success', 'Files uploaded successfully.');
    }
 
    
    // Delete function 
    public function delete($id){
        $fileUpload = FileUpload::find(decrypt($id));
        if($fileUpload) {
            $fileUpload->delete();
            return response()->json([
                'data' => 'success'
            ]);
        } else {
            return response()->json([
                'error' => 'Record not found'
            ], 404); 
        }
    }
    

   


    public function download($filename)
    {
        $path = 'uploads/' . $filename;
        return Storage::download($path);
    }


}
