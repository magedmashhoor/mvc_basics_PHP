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
}