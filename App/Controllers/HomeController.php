<?php

namespace App\Controllers;


class HomeController
{

    public function index()
    {
       return view('home');
    }
    public function items()
    {
       return view('items');
    }
    public function login()
    {
       return view('login');
    }
    public function user()
    {
       return view('user');
    }
    public function out()
    {
       return view('out');
    }
    public function Categorys()
    {
         return view('categorys');
    }
    public function orders()
    {
      return view('orders');
    }
    public function Addorders()  {
      return view('AddOrders');
      
    }
    public function customers()
    {
      return view('customers');
    }
    public function expenses()
    {
      return view('expenses');
    }
    public function dashboard()
    {
      return view('dashboard');
      
    }
    public function brands()
    {
      return view('brands');
    }
    public function Accounts()
    {
      return view('Accounts');
    }
    
}