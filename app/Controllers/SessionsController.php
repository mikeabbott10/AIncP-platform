<?php
namespace App\Controllers;

use CodeIgniter\Database\Query;
use App\Models\SessionModel;

class SessionsController extends BaseController{
    public function index($subjId){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['currentpage'] = 'Subjects';

        $data['sessions'] = $this->loadSessionsFromSubject($subjId);
        $data['subject'] = $this->loadSubject($subjId);
        return view('pages/dashboard/sessions', $data);   
    }

    /**
     * delete session
     * @param id
     */
    public function delete_session($subjId, $id=-1){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['currentpage'] = 'Subjects';
        
        $sessionModel = new SessionModel();
        $sessionModel->delete($id);
        return redirect()->route("dashboard/subject/{$subjId}/sessions");
    }


    private function loadSessionsFromSubject($id){
        // Prepare the Query
        $pQuery = $this->db->prepare(static function ($db) {
            $sql = 'SELECT 
                fpo.id as id,
                fpo.start_time as start_time, fpo.end_time as end_time, 
                fpa.path as filepath, 
                t.label as tag
                FROM fileportions fpo 
                left outer join filepaths fpa on fpa.id = fpo.file_id 
                left outer join tags t on fpo.tag_id = t.id
                WHERE fpa.subj_id = ?';

            return (new Query($db))->setQuery($sql);
        });

        // Run the Query
        $results = $pQuery->execute($id);
        return $results->getResultArray();
    }
}
