<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use DB;
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
        $files = $request['file'];
        if(count($files) > 0){
            foreach($files as $file) {
                $docName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = mt_rand().'.'.$extension;
                $file->storeAs('public/documents',$filename);
                // $images[] = $filename;
                $document->file = $filename;
            }     
        }
        // dd($request);
        $document->name = $docName;
        $document->recipient_email = $request->input('recipient_email');
        $document->transaction_id = mt_rand();
        $document->user_id = Auth::user()->id;
        $document->save();
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

    public function filedownload($id){
        $document = Document::find($id);
        $file_name = $document->file;
        $pathToFile = public_path('storage/documents/'.$file_name);
        return response()->download($pathToFile);
      
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
