<?php

namespace App\Controllers;

use App\Models\User_Model;
use App\Models\Kategori_Model;

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

    public function artkat($id_kategori)
    {
        $kategoriModel = new Kategori_Model();
        $categories = $kategoriModel->getCategories();
        $articles = $kategoriModel->getArticlesByKategori($id_kategori);

        // cari nama kategori berdasarkan id_kategori yang dipilih menggunakan array_filter
        $kategori = array_filter($categories, function ($kategori) use ($id_kategori) {
            return $kategori['id_kategori'] == $id_kategori;
        });

        $data = [
            'current_page' => 'dashboard',
            'page' => 'user/artkat',
            'articles' => $articles,
            'categories' => $categories,
            'kategori_nama' => !empty($kategori) ? reset($kategori)['nama_kategori'] : ''
        ];

        return view('template', $data);
    }
}