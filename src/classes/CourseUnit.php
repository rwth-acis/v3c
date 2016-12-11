<?php

/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 11/12/2016
 * Time: 12:51
 */
class CourseUnit
{
    protected $id;
    protected $lang;
    protected $title;
    protected $description;
    protected $start_date;
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
        $this->points = $data['points'];
        $this->start_date = $data['start_date'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->date_created = $data['date_created'];
        $this->date_updated = $data['date_updated'];
    }
    public function getId() {
        return $this->id;
    }
    public function getTitle() {
        return $this->title;
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
    public function getStartDate() {
        return $this->start_date;
    }
    public function getPoints() {
        return $this->points;
    }
    public function getDateCreated() {
        return $this->date_created;
    }
    public function getDateUpdated() {
        return $this->date_updated;
    }
}
