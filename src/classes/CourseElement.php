<?php

/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 10/12/2016
 * Time: 01:30
 */
class CourseElement
{
    protected $id;
    protected $lang;
    protected $title;
    protected $description;
    protected $points;
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
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->points = $data['points'];
        $this->date_created = $data['date_created'];
        $this->date_updated = $data['date_updated'];
    }
    public function getId() {
        return $this->id;
    }
    public function getTitle() {
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
    public function getPoints() {
        return $this->creator;
    }
    public function getDateCreated() {
        return $this->date_created;
    }
    public function getDateUpdated() {
        return $this->date_updated;
    }
}