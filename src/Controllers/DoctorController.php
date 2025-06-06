<?php
namespace App\Controllers;

use App\Models\Users;
use Core\View\View;
use Core\Requests;

class DoctorController
{
    public function __construct()
    {
    }

    public function add()
    {
        View::render('doctor/add');
    }

    public function store(Requests $request)
    {
        $data = $request->all();
        $user = new Users();
        
        try {
            // Add validation here later
            $result = $user->addDoctor($data);
            
            if ($result) {
                header('Location: /doctors/add?success=1');
                exit;
            }
        } catch (\Exception $e) {
            // Log error here
        }
        
        header('Location: /doctors/add?error=1');
        exit;
    }

    public function delete()
    {
        View::render('doctor/delete');
    }

    public function search(Requests $request)
    {
        $data = $request->all();
        $query = $data['query'] ?? '';
        
        $user = new Users();
        $doctors = $user->searchDoctors($query);
        
        header('Content-Type: application/json');
        echo json_encode($doctors);
        exit;
    }

    public function destroy(Requests $request)
    {
        $data = $request->all();
        $doctorId = $data['doctor_id'] ?? '';
        
        if (empty($doctorId)) {
            header('Location: /doctors/delete?error=1');
            exit;
        }
        
        $user = new Users();
        
        try {
            $result = $user->deleteDoctor($doctorId);
            
            if ($result) {
                header('Location: /doctors/delete?success=1');
                exit;
            }
        } catch (\Exception $e) {
            // Log error here
        }
        
        header('Location: /doctors/delete?error=1');
        exit;
    }
}