<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\DocumentResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BossController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
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
