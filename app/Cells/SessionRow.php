<?php

class Session{
    public function show($data): string{
        return view('Components/session/session_row', $data);
    }
}