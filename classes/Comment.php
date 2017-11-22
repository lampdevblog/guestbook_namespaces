<?php
namespace Guestbook\Classes;

class Comment extends DB
{
    public $id;
    public $userId;
    public $comment;
    public $createdAt;

    public function save()
    {
        $stmt = $this->conn->prepare('INSERT INTO comments(`user_id`, `comment`) VALUES(:user_id, :comment)');
        $stmt->execute(array('user_id' => $this->userId, 'comment' => $this->comment));
        $this->id = $this->conn->lastInsertId();
        return $this->id;
    }

    public function findAll()
    {
        $stmt = $this->conn->prepare('SELECT * FROM comments ORDER BY id DESC');
        $stmt->execute();
        $comments = [];
        while ($row = $stmt->fetch(\PDO::FETCH_LAZY)) {
            $comments[] = ['id' => $row->id, 'user_id' => $row->user_id, 'comment' => $row->comment, 'created_at' => $row->created_at];
        }
        return $comments;
    }
}
