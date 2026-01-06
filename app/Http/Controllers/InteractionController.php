<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Review;
use App\Models\Comment;

class InteractionController extends Controller
{

    // 1. Simpan Review Baru
    public function storeReview(Request $request, $story_id)
    {
        $request->validate([
            'body' => 'required|min:5',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $existing = Review::where('user_id', Auth::id())->where('story_id', $story_id)->first();
        if($existing) {
            return back()->with('error', 'Anda sudah mereview cerita ini. Silakan edit ulasan lama.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'story_id' => $story_id,
            'body' => $request->body,
            'rating' => $request->rating,
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim!');
    }

    // 2. Halaman Edit Review
    public function editReview($id)
    {
        $review = Review::findOrFail($id);

        if (Auth::id() !== $review->user_id) {
            return back()->with('error', 'Anda tidak berhak mengedit ulasan ini.');
        }

        return view('reviews.edit', compact('review'));
    }

    // 3. Proses Update Review
    public function updateReview(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        if (Auth::id() !== $review->user_id) {
            abort(403);
        }

        $request->validate([
            'body' => 'required|min:5',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review->update([
            'body' => $request->body,
            'rating' => $request->rating,
        ]);

        return redirect()->route('story.show', $review->story->slug)
                         ->with('success', 'Ulasan berhasil diperbarui!');
    }

    // 4. Hapus Review
    public function destroyReview($id)
    {
        $review = Review::findOrFail($id);

        if (Auth::id() !== $review->user_id) {
            return back()->with('error', 'Akses ditolak.');
        }

        $review->delete();
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }

    // 1. Simpan Komentar
    public function storeComment(Request $request, $chapter_id)
    {
        $request->validate(['body' => 'required|max:500']);

        Comment::create([
            'user_id' => Auth::id(),
            'chapter_id' => $chapter_id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Komentar terkirim!');
    }

    // 2. Halaman Edit Komentar
    public function editComment($id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::id() !== $comment->user_id) {
            return back()->with('error', 'Bukan komentar Anda.');
        }

        return view('comments.edit', compact('comment'));
    }

    // 3. Proses Update Komentar
    public function updateComment(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $request->validate(['body' => 'required|max:500']);

        $comment->update(['body' => $request->body]);

        return redirect()->route('chapter.read', [$comment->chapter->story->slug, $comment->chapter->slug])
                         ->with('success', 'Komentar diperbarui.');
    }

    // 4. Hapus Komentar
    public function destroyComment($id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::id() !== $comment->user_id) {
            return back()->with('error', 'Gagal menghapus.');
        }

        $comment->delete();
        return back()->with('success', 'Komentar dihapus.');
    }
}