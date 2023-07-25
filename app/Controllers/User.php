<?php

namespace App\Controllers;

use App\Models\User_Model;

class User extends BaseController
{
    public function home()
    {
        $data = [
            'current_page' => 'home',
            'page' => 'user/home', 
        ];
        return view('template', $data);
    }
    public function search()
    {
        $data = [
            'current_page' => 'search',
            'page' => 'user/search', 
        ];
        return view('template', $data);
    }
    public function artikel($id)
    {
        $artikelModel = new User_Model();
        $article = $artikelModel->find($id);
        
        if ($article) {
            $data = [
                'page' => 'user/artikel',
                'artikel' => $article
            ];
            return view('template', $data);
        } else {
            return view('errors/html/error_404');
        }
    }
}