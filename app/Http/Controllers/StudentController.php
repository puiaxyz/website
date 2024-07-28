<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Fetch student information and payment status
        $student = auth()->user(); // Assuming the logged-in user is a student
        $payments = $student->payments; // Adjust as per your data structure
        
        return view('student.dashboard', compact('student', 'payments'));
    }
}
