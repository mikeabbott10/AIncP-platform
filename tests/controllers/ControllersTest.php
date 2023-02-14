<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Shield\Controllers\LoginController;

class SubjectsControllerTest extends CIUnitTestCase
{
    use ControllerTestTrait;

    /**
     * Login controller shows login page
     */
    public function testLoginController()
    {
        $result = $this->withURI('http://aincp-platform.local/login')
            ->controller(LoginController::class)
            ->execute('loginView');

        $result->assertSee('Login', 'button');
    }

    /**
     * test show subjects controller
     */
    public function testShowSubjects()
    {
        $result = $this->withURI('http://aincp-platform.local/dashboard/subject')
            ->controller(\App\Controllers\SubjectsController::class)
            ->execute('index');

        $this->assertTrue($result->isOK());
        $result->assertSee('Code', 'th');
        $result->assertSee('AHA', 'th');
        $result->assertSee('MACS', 'th');
    }


    private function stub_getSubjectDataFromDb(){
        $subjectStub = array();
        $subjectStub['id'] = '1';
        $subjectStub['name'] = "Mario";
        $subjectStub['surname'] = "Stub";
        $subjectStub['code'] = "123";
        $subjectStub['dominance'] = "R";
        $subjectStub['macs'] = '5';
        $subjectStub['aha'] = '80';
        $subjectStub['hemi'] = '1';
        $subjectStub['gender'] = "M";
        return $subjectStub;
    }

    /**
     * test subject card auto population
     */
    public function testSubjectCardPopulation()
    {
        // get subject data
        $subjectData = $this->stub_getSubjectDataFromDb();

        $result = $this
            ->controller(\App\Controllers\SubjectsController::class)
            ->execute('stub_subject_card', $subjectData);

        $this->assertTrue($result->isOK());
        $result->assertSee('Subject Card', 'li');
        foreach ($subjectData as $key => $value) {
            $result->assertSee($value);
        }
    }
}