<?php

namespace Core\Repositories;

interface CourseStudentRepositoryContract
{
    public function all();
    public function paginate();
    public function find($id);
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
}