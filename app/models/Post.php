<?php


class Post
{
    private $db;

    /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getPosts()
    {
        $this->db->query('
            SELECT *,
            posts.id as postId,
            users.id as userId,
            posts.created_at as postCreated
            FROM posts
            INNER JOIN users
            ON posts.user_id = users.id
            ORDER BY posts.created_at DESC
        ');
        $result = $this->db->getAll();
        return $result;
    }

    public function getPostById($id)
    {
        $this->db->query('SELECT *,
            posts.id AS postId,
            users.id AS userId,
            posts.created_at AS postCreated
            FROM posts
            JOIN users
            ON posts.user_id = users.id 
            JOIN post_tags 
            ON posts.id=post_tags.post_id 
            WHERE post_tags.tag_id=:id');
        $this->db->bind('id', $id);
        return $result = $this->db->getAll();
    }

    public function deletePost($id)
    {
        $this->db->query('DELETE FROM posts WHERE id=:id');
        $this->db->bind(':id', $id);
        $result = $this->db->execute();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function editPost($data)
    {
        $this->db->query('UPDATE posts SET title=:title, content=:content WHERE id=:id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        $result = $this->db->execute();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function addPost($data)
    {
        $this->db->query('INSERT INTO posts (title, user_id, content) VALUES(:title, :user_id, :content)');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':content', $data['content']);
        $result = $this->db->execute();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}