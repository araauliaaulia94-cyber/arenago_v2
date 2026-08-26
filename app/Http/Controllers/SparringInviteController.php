<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\SparringInvite;
use App\Models\SparringPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SparringInviteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created invitation.
     */
    public function store(Request $request, SparringPost $sparringPost)
    {
        $validated = $request->validate([
            'team_name' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        if ($sparringPost->user_id === auth()->id()) {
            return back()->withErrors([
                'team_name' => 'Anda tidak dapat mengirim tantangan ke postingan milik Anda sendiri.',
            ]);
        }

        if (! in_array($sparringPost->status, ['open', 'full'])) {
            return back()->withErrors([
                'team_name' => 'Postingan ini sudah tidak menerima tantangan sparring baru.',
            ]);
        }

        $alreadySent = SparringInvite::where('sparring_post_id', $sparringPost->id)
            ->where('sender_user_id', auth()->id())
            ->where('status', 'pending')
            ->exists();

        if ($alreadySent) {
            return back()->withErrors([
                'team_name' => 'Anda sudah mengirim tantangan ke postingan ini dan masih menunggu konfirmasi host.',
            ]);
        }

        DB::transaction(function () use ($validated, $sparringPost) {
            $sparringPost->invites()->create([
                'sender_user_id' => auth()->id(),
                'team_name' => $validated['team_name'],
                'message' => $validated['message'] ?? null,
                'status' => 'pending',
            ]);

            Notification::create([
                'user_id' => $sparringPost->user_id,
                'title' => 'Tantangan Sparring Baru',
                'message' => $validated['team_name'].' menantang tim '.$sparringPost->team_name.' untuk pertandingan '.$sparringPost->title.' di '.$sparringPost->location.'.',
                'type' => 'sparring',
                'is_read' => false,
                'link' => route('sparring.show', $sparringPost),
            ]);
        });

        return back()->with('status', 'Tantangan sparring berhasil dikirim ke tim host!');
    }

    /**
     * Display the specified invitation.
     */
    public function show(SparringInvite $sparringInvite)
    {
        //
    }

    /**
     * Show the form for editing the specified invitation.
     */
    public function edit(SparringInvite $sparringInvite)
    {
        //
    }

    /**
     * Update the specified invitation.
     */
    public function update(Request $request, SparringInvite $sparringInvite)
    {
        //
    }

    /**
     * Remove the specified invitation.
     */
    public function destroy(SparringInvite $sparringInvite)
    {
        //
    }
}
