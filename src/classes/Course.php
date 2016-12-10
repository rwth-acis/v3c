<?php

/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 09/12/2016
 * Time: 23:30
 */
class Course
{
    protected $id;
    protected $lang;
    protected $name;
    protected $description;
    protected $profession;
    protected $creator;
    protected $domain;
    protected $date_created;
    protected $date_updated;

    /**
     * Accept an array of data matching properties of this class
     * and create the class
     *
     * @param array $data The data to use to create
     */
    public function __construct(array $data) {
        // no id if we're creating
        if(isset($data['id'])) {
            $this->id = $data['id'];
        }
        $this->lang = $data['lang'];
        $this->creator = $data['creator'];
        $this->profession = $data['profession'];
        $this->domain = $data['domain'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->date_created = $data['date_created'];
        $this->date_updated = $data['date_updated'];
    }
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getShortDescription() {
        return substr($this->description, 0, 20);
    }
    public function getLang() {
        return $this->lang;
    }
    public function getCreator() {
        return $this->creator;
    }
    public function getProfession() {
        return $this->profession;
    }
    public function getDomain() {
        return $this->domain;
    }
    public function getDateCreated() {
        return $this->date_created;
    }
    public function getDateUpdated() {
        return $this->date_updated;
    }
}