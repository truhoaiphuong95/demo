<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Core\Services\CourseServiceContract;
use Core\Services\CourseRelatedService;
use App\Models\CourseStudent;

class CourseController extends Controller
{
    protected $service;
    protected $relateService;

    public function __construct(CourseServiceContract $service, CourseRelatedService $related)
    {
        $this->service = $service;
        $this->relateService = $related;
    }
    
    public function getList() {
        $data['courses'] = $this->service->list();
        $data['expected_courses'] = $this->service->getExpected();
        return view('course-list', $data);
    }
    
    public function getAdd() {
        $data['course_groups'] = $this->relateService->group->all();
        return view('course-add',$data);
    }
    
    public function postAdd(Request $req) {
        $course_id = $this->service->store($req);
        return redirect()->route('staff.course.list.get')->with('success', 'Đã thêm thành công!');
    }

    public function getEdit($course_id) {
        $data['course_groups'] = $this->relateService->group->all();
        $data['course'] = $this->service->find($course_id);
        return view('course-edit', $data);
    }
    
    public function postEdit($course_id, Request $req) {        
        $course_id = $this->service->update($course_id, $req);
        return redirect()->route('staff.course.list.get')->with('success', 'Lưu thay đổi thành công!');
    }
    
    public function getView($course_id) {
        $data['course'] = $this->service->show($course_id);
        $data['students'] =  $data['course']->courseStudents->map(function ($item, $key) {
            $item->client->first_name = array_slice(explode(' ', $item->client->name), -1)[0];
            return $item;
        })->sortBy('client.first_name');
        return view('course-studentlist', $data);
    }

    public function getPhoneList($course_id) {
        $data['students'] = $this->service->find($course_id)->courseStudents;
        return view('course-phonelist', $data);
    }

    public function getExportExcel($course_id)
    {
        return $this->service->download($course_id);
    }

    public function getDelete($course_id)
    {
        $data['course'] = $this->service->find($course_id);
        return view('course-delete', $data);
    }

    public function postDelete($course_id, Request $req)
    {
        $course = $this->service->find($course_id);
        if($req->delete_shortname != $course->shortname) {
            return redirect()->back()->withErrors('Xác nhận sai, xin thử lại!');
        }

        //CourseStudentwhere('course_id', $course_id)->delete();

        CourseStudent::where('course_id', $course_id)->delete();
        $course->delete();

        return redirect()->route('staff.course.list.get')->with('success', 'Xoá thành công!');
    }
}
