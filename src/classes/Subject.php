<?php

/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 14/12/2016
 * Time: 17:22
 */
class Subject
{
    public $id;
    public $name;
    public $img_url;
    public $created_at;
    public $updated_at;

    public function __construct(array $data)
    {
        // no id if we're creating
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
        $this->img_url = $data["img_url"];
        $this->name = $data['name'];
        $this->created_at = $data['created_at'];
        $this->date_updated = $data['updated_at'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getImgUrl()
    {
        return $this->img_url;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}