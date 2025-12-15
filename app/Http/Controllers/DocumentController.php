<?php

namespace App\Http\Controllers;

use App\Http\Resources\DocumentResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateDocumentRequest;
use App\Models\Document;

class DocumentController extends Controller
{
    public function create_document(CreateDocumentRequest $createDocumentRequest){
        $validated_data = $createDocumentRequest->validated();
        $validated_data['creator'] = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $validated_data['create_date'] = Carbon::now()->format('Y/m/d');
        $document = Document::create($validated_data);
        return new DocumentResource($document);
    }

    public function get_document(Document $document){
        return new DocumentResource($document); 
    }

    public function delete_document(Document $document){
        if((bool)$document){
            $document->delete();
        }else{
            return response()->json([
                'there is not exist!'
            ] , 403);
        }
    }
}
