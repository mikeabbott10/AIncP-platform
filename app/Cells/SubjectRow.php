<?php

class SubjectRow{
    public function show($subject): string{
        $data['subject'] = $subject;
        return view('Components/subject/subject_row', $data);
    }
}