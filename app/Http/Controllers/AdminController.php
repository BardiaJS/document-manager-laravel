<?php

namespace App\Http\Controllers;

use App\Models\Document;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\DocumentResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // این را اضافه کنید

class AdminController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function accept_admin(Document $document){
        $this->authorize('viewDocumentAdmin', $document);
        $document->is_document_admin_signed = true;
        $document->save();
        return new DocumentResource($document);
    }

    public function reject_admin(Document $document , Request $request){
        $this->authorize('viewDocumentAdmin', $document);
        $response = $request->validate([
            'response' => 'required'
        ]);
        $document->is_document_admin_signed = false;
        $document->response = $response;
        $document->save();
        return new DocumentResource($document);
    }
    public function get_document(Document $document){
        $this->authorize('viewDocumentAdmin', $document);
        return new UserResource($document);
    }
}
