<?php

namespace App\Http\Controllers;

use App\Scraping\InstaCrawler;

class HomeController extends Controller
{
    /**
     * Home
     *
     * @return view
     */
    public function home()
    {
        //$instaCrawler = new InstaCrawler('_piroska'); //private account
        $instaCrawler = new InstaCrawler('annamariasaake'); //private public Account
        //$instaCrawler = new InstaCrawler('take_tv'); //business account

        $instaCrawler->filterBusinessAddress();
        dump($instaCrawler->getBusinessAddress());

        $instaCrawler->filterUserData();
        dump($instaCrawler->getUser());

        $instaCrawler->filterPosts();
        dump($instaCrawler->getPosts());

        return view('welcome');
    }
}
