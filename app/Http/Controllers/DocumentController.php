<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $files = Document::all();
        return view('admin.files')->with('files', $files);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('user.send');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            // 'title' => 'required',
            'recipient_email' => 'required',
            'file' => 'required'
            
           
        ]);

        $document = new Document;
        if($request->hasFile('file')){
            $file = $request['file'];
            $filename = $file->getClientOriginalName();
            // dd($filename)
            $file->storeAs('public/documents',$filename);
            $document->file = $filename;
                 
        }
        $document->name = $filename;
        $document->recipient_email = $request->input('recipient_email');
        $document->transaction_id = mt_rand();
        $document->user_id = Auth::user()->id;
        // dd($request);
        $document->save();
        return redirect('/index')->with('success', 'Document Sent and Saved Successfully!');
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $file = Document::find($id);
        return view('user.show')->with('file', $file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filedownload($id){
        $document = Document::find($id);
        $file_name = $document->file;
        $pathToFile = public_path('storage/documents/'.$file_name);
        // dd($pathToFile);
        return response()->download($pathToFile);
      
    }
}
