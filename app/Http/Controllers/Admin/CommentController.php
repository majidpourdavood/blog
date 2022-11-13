<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\SendEmailAll;
use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('site.admin.comments.index');
    }

    public function commentUnSuccessFull()
    {
        $comments = Comment::where('approved', 0)->paginate(100);
        return view('site.admin.comments.commentUnSuccessFull', compact('comments'));
    }

    public function commentSuccessFull()
    {
        $comments = Comment::where('approved', 1)->paginate(100);
        return view('site.admin.comments.commentSuccessFull', compact('comments'));
    }

    public function commentAll()
    {
        $comments = Comment::orderBy('created_at', 'desc')->paginate(100);
        return view('site.admin.comments.all', compact('comments'));
    }


    public function getReplyCommentAdmin($id)
    {
        $comment = Comment::findOrFail($id);
        return view('site.admin.comments.replyCommentAdmin', compact(['comment']));
    }

    public function postReplyCommentAdmin(Request $request)
    {
        $this->validate($request, [
            'parent_id' => 'required',
            'comment' => 'required',
            'commentable_id' => 'required',
            'commentable_type' => 'required',
        ]);
        $codeNumber = randomNumber(9);
        if (in_array(trim($codeNumber), Comment::all()->pluck('codeNumber')->toArray())) {
            $codeNumber = randomNumber(9);
        }
        $comment = new Comment();
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->comment;
        $comment->approved = 1;
        $comment->codeNumber = $codeNumber;
        $comment->name = \auth()->user()->name . ' ' . \auth()->user()->lastName;
        $comment->email = auth()->user()->email;
        $comment->commentable_id = $request->commentable_id;
        $comment->commentable_type = $request->commentable_type;
        $comment->save();


        $parentComment = Comment::findOrfail($request->parent_id);
        $parentComment->approved = 1;
        $parentComment->update();


//      send email for user
        switch ($parentComment->commentable_type) {
            case "App\Model\Blog":
                $dataNotifyUrl = route('blog', ['slug' => $parentComment->commentable->slug]);
                break;
            default:
                $dataNotifyUrl = "/";
        }

        $titleJob = translate('Reply to the comment');;
        $bodyJob = "";
        $textBtnJob = translate('Show post and comment');
        $colorBtnJob = "green";
        $descriptionJob = translate('Your comment on the article') . " " . $parentComment->commentable->title . "  " .translate('The answer has been given.');
        $urlJob = $dataNotifyUrl;

        $emailJob = $parentComment->email;
        $details = [
            "titleEmail" => $titleJob,
            "title" => $titleJob,
            "description" => $descriptionJob,
            "body" => $bodyJob,
            "colorBtn" => $colorBtnJob,
            "textBtn" => $textBtnJob,
            "url" => $urlJob,
            "email" => $emailJob,
        ];

        if (filter_var($emailJob, FILTER_VALIDATE_EMAIL)) {
            $dispatch = dispatch(new SendEmailAll($details));
        }


        alert()->success(translate('Your comment has been registered successfully'), translate('Send a comment'))
            ->confirmButton(translate('OK'))->autoclose(3000);
        return redirect()->route('commentAll');

    }


    public function approved(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['approved' => 1]);

        switch ($comment->commentable_type) {
            case "App\Model\Blog":
                $dataNotifyUrl = route('blog', ['slug' => $comment->commentable->slug]);
                break;
            default:
                $dataNotifyUrl = "/";
        }


        $titleJob = translate('Comment confirmation');;
        $bodyJob = "";
        $textBtnJob = translate('Show post and comment');
        $colorBtnJob = "green";
        $descriptionJob = translate('Your comment on the article') . " " . $comment->commentable->title . "  " .translate('Confirmed.');
        $urlJob = $dataNotifyUrl;

        $emailJob = $comment->email;
        $details = [
            "titleEmail" => $titleJob,
            "title" => $titleJob,
            "description" => $descriptionJob,
            "body" => $bodyJob,
            "colorBtn" => $colorBtnJob,
            "textBtn" => $textBtnJob,
            "url" => $urlJob,
            "email" => $emailJob,
        ];

        if (filter_var($emailJob, FILTER_VALIDATE_EMAIL)) {
            $dispatch = dispatch(new SendEmailAll($details));
        }

        alert()->success(translate('Comment edit was successfully registered'), translate('Edit the comment'))
            ->confirmButton(translate('OK'))->autoclose(3000);
        return back();
    }


    public function destroy($id)
    {

        $comment = Comment::find($id);
        $comment->delete();
        alert()->success(translate('Your comment has been successfully deleted'), translate('Delete comment'))
            ->confirmButton(translate('OK'))->autoclose(3000);
        return back();
    }
}
