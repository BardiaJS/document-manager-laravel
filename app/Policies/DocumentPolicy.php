<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Document;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewDocumentAdmin(User $user , Document $document): bool
    {
        return (!($document->is_document_admin_signed) and ($user->is_document_admin == 1));
    }

    public function viewDocumentManager(User $user , Document $document): bool
    {
        return ($document->is_document_admin_signed and $user->is_document_manager);
    }
    public function viewBoss(User $user , Document $document): bool
    {
        return  ($document->is_document_manager_signed and $user->is_boss) ;
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Document $document): bool
    {
        // 1. صاحب سند همیشه می‌تواند ببیند
        if ($document->user_id === $user->id) {
            return true;
        }

        // 2. مدیر اسناد می‌تواند اسناد امضا نشده را ببیند
        if ($this->viewDocumentAdmin($user, $document)) {
            return true;
        }

        // 3. مدیر می‌تواند اسناد امضا شده توسط مدیر اسناد را ببیند
        if ($this->viewDocumentManager($user, $document)) {
            return true;
        }

        // 4. رئیس می‌تواند اسناد امضا شده توسط مدیر را ببیند
        if ($user->is_boss) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): bool
    {
        return $document->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): bool
    {
        return $document->user_id == $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Document $document): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Document $document): bool
    {
        return $user->is_boss or $user->is_document_manager or $user->is_document_admin;
    }
}
