<?php

namespace App\Http\Controllers;

use App\Http\Resources\DocumentResource;
use App\Http\Resources\UserResource;
use App\Models\Document;
use Illuminate\Http\Request;

class BossController extends Controller
{
    public function accept_boss(Document $document){
        $this->authorize('viewBoss', $document);
        $document->is_boss_signed= true;
        $document->response = "Accepted";
        $document->save();
        return new DocumentResource($document);
    }

    public function reject_boss(Document $document , Request $request){
        $this->authorize('viewBoss', $document);
        $response = $request->validate([
            'response' => 'required'
        ]);
        $document->is_boss_signed = false;
        $document->response = $response;
        $document->save();
        return new DocumentResource($document);
    }

    public function get_document(Document $document){
        $this->authorize('viewBoss', $document);
        return new UserResource($document);
    }
}
