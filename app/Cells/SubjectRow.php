<?php

class SubjectRow{
    public function show($subject): string{
        $data['subject'] = $subject['subj'];
        return view('Components/subject_row', $data);
    }
}