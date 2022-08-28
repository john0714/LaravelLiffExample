<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only(['store', 'destory']);
    }

    public function index()
    {
        $posts = Post::latest()->with(['user', 'likes'])->paginate(20); // 페이지 형태로 값 출력(안의 값은 페이지당 출력할 갯수)

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);

        $request->user()->posts()->create($request->only('body'));

        return back(); // 특정 작업 후 그 화면으로 돌아감. 리로드는 자바스크립트의 location.reload()쓰면 될듯
    }

    public function destory(Post $post)
    {
        // 삭제에 대한 룰을 지정함. 제1인수는 Policy함수명임.
        // Policy는 app/Policies에 작성하며(이번엔 PostPolicy.php), app/AuthServiceProvider.php에 작성한 클래스를 지정함.
        // 인수중 $user는 laravel에 로그인되있는 auth를 그대로 가져오므로, 그 외의 인수($post)만 지정 해주면 된다.
        $this->authorize('delete', $post);
        $post->delete();

        return back();
    }
}
