<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'exclude' => 'array',
        'alsomatch' => 'array'
    ];

    public $timestamps = true;
    public $table = 'courses';
    public $dates = ['deleted_at'];
    public $fillable = ['name', 'shortname', 'lesson', 'opening_at', 'schedule', 'maxseat', 'teacher', 'tuition', 'note', 'exclude' , 'alsomatch', 'is_expected', 'course_group_id'];
    public $revenue = 0;
    public $collected = 0;

    public function __construct()
    {
    }

    public function courseStudents()
    {
        return $this->hasMany('App\Models\CourseStudent');
    }

    public function linkName() {
        return '<a href="'.route('staff.course.view.get', ['course_id' => $this->id], false).'">'.$this->name.'</a>';
    }

    public function sum() {
        return count($this->courseStudents);
    }

    public function sumDone() {
        $students_done = $this->courseStudents;
        $count = 0;
        foreach($students_done as $data) {
            if($data->tuition_done >= ($this->tuition*((100-$data->deal_rate)/100))) $count++;
        }
        return $count;
    }

    public function isDone()
    {
        return $this->sumDone()==$this->sum();
    }

    public function sumDeposited() {
        $students_done = $this->courseStudents;
        $count = 0;
        foreach($students_done as $data) {
            if($data->tuition_done > 0  or $data->deal_rate == 100) $count++;
        }
        $count -= $this->sumDone();
        return $count;
    }

    public function revenue()
    {
        $revenue = 0;
        foreach($this->courseStudents as $student) {
            $revenue += TuitionAfter($this->tuition, $student->deal_rate);
        } 
        return $revenue;
    }

    public function collected()
    {
        $collected = 0;
        foreach($this->courseStudents as $student) {
            $collected += $student->tuition_done;
        } 
        return $collected;
    }

    public function isFull()
    {
        return ($this->sumDone() >= $this->maxseat);
    }

    public function getAlsoMatch()
    {
        $course_group_ids = Course_group::findMany($this->alsomatch)->pluck('id')->toArray();
        return Course::whereIn('course_group_id', $course_group_ids)->pluck('id')->toArray();
    }

    public function getExcludes()
    {
        $course_group_ids = Course_group::findMany($this->exclude)->pluck('id')->toArray();
        return Course::whereIn('course_group_id', $course_group_ids)->pluck('id')->toArray();
    }

    public function getPotentials()
    {
        //$client_ids = CourseStudentwhereIn('course_id', $this->getAlsoMatch())->whereNotIn('course_id', $this->getExcludes())->pluck('client_id')->toArray();
        
        $client_ids = CourseStudent::whereIn('course_id', $this->getAlsoMatch())->whereNotIn('course_id', $this->getExcludes())->pluck('client_id')->toArray();
        return Client::whereIn('id', $client_ids)->get();
    }
}
