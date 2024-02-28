<?php
require_once 'util.php';
class TopicValidator
{
    private $topic;
    private $errors = [];
    private static $fields = ['title', 'body'];

    public function __construct($topic)
    {
        $this->topic = $topic;
    }
    public function validateForm()
    {
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->topic)) {
                trigger_error("'$field' is not present in the data");
                return;
            }
        }
        $this->validateTitle();
        $this->validateBody();
        return $this->errors;
    }
    public function validateTitle()
    {
        if (strlen($this->topic['title']) < 4 || strlen($this->topic['title']) > 140) {
            $this->addError('title', 'หัวข้อกระทู้ต้องมีความยาวระหว่าง 4-140 ตัวอักษร');
        } else if (preg_match('/<[^>]*>/', $this->topic['title'])) {
            $this->addError('title', 'หัวข้อกระทู้ไม่สามารถมี tag html ได้');
        }
    }
    public function validateBody()
    {
        $body = strip_tags($this->topic['body']);
        if (strlen($body) < 6 || strlen($body) > 2000) {
            $this->addError('body', 'เนื้อหากระทู้ต้องมีความยาวระหว่าง 6-2000 ตัวอักษร');
        }
    }
    private function addError($key, $val)
    {
        $this->errors[$key] = $val;
    }
}
