<?php


class Tags extends Controller
{
    public function __construct()
    {
        $this->tagsModel = $this->model('Tag');
        $this->postsModel = $this->model('Post');
    }

    public function index()
    {
        $tags = $this->tagsModel->getTags();
        $data = array(
            'tags' => $tags
        );
        $this->view('tags/index', $data);
    }

    public function show($id)
    {
        $posts = $this->postsModel->getPostsByTagId($id);
        $data = [
            'posts' => $posts
        ];
        $this->view('tags/show', $data);
    }
}