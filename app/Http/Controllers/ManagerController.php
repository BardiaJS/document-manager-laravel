<?php

namespace App\Http\Controllers;

use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function accept_manager(Document $document){
        $document->is_document_manager_signed = true;
        $document->save();
        return new DocumentResource($document);
    }

    public function reject_manager(Document $document , Request $request){
        $response = $request->validate([
            'response' => 'required'
        ]);
        $document->is_document_manager_signed = false;
        $document->response = $response;
        return new DocumentResource($response);
    }
}
