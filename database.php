<?php

require_once 'config.php';

class Database extends Config
{
    public function read()
    {
        $sql = "SELECT * FROM topics ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function readLast()
    {
        $sql = "SELECT * FROM topics ORDER BY created_at DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function insert($title, $body)
    {

        $sql = "INSERT INTO topics (title, body) VALUES (:title, :body)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'title' => $title,
            'body' => $body
        ]);
        return true;
    }
    public function update($id, $title, $body)
    {
        $sql = "UPDATE topics SET title = :title, body = :body WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'title' => $title,
            'body' => $body
        ]);
        return true;
    }
    public function delete($id)
    {
        $sql = "DELETE FROM topics WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
    }
}
