<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Mail\SentFiles;
use Mail;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware(['auth']);
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
            'recipient_email' => 'required',
            'file' => 'required'
        ]);

        $files = $request['file'];
        // dd($files);
        $id = mt_rand();
        if($files){
            foreach($files as $file) {
                $docName = $file->getClientOriginalName();
                $originalName = pathinfo($docName,PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = mt_rand().'.'.$extension;
                $filePath = 'documents/' . $id .'/'.$filename;
                $file->storeAs('public/documents'.$id, $filename);
                // Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');
                $data[] = $originalName;
            }     
        }
        $name = implode(',' , $data);
        $document = new Document();
        $document->file = $name;
        $document->title = $name;
        $document->message = $request['message'];
        $document->user_id = Auth::user()->id;
        $document->transaction_id = $id;
        $document->recipient_email = $request['recipient_email'];
        $document->save();
        // dd($document);
        $attachedFiles = public_path().'\storage\documents'.$id;
        $files = File::allFiles($attachedFiles);
        $sender = Auth::user()->email;
        $message = $request['message'];

        
        Mail::to($request['recipient_email'])->send(new SentFiles($files, $sender, $message));
        
        return redirect('/dashboard')->with('success', 'Document Sent and Saved Successfully!');

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


    public function search(Request $request){
        $user = Auth::user()->id;
        $transaction_id = $request->get('transaction_id');
        $email = $request->get('e-mail');
        $files = DB::table('documents')->where('transaction_id', 'LIKE', '%'.$transaction_id.'%')->where('recipient_email', 'LIKE','%'.$email.'%')->get();
        if($files){
            return view('user.dashboard')->with('files', $files);
        }else{
            return view('user.dashboard')->with('success', 'No file found!');
        }
    }
}
