<?php

namespace App\Controllers;

class PostControllers
{
    public function user()
    {
         return viewpost('User');
    }
    public function items()
    {
         return viewpost('items');
    }
    public function Login()
    {
         return viewpost('Login');
    }
    public function Category()
    {
     return viewpost('Category');
    }
    public function info()
    {
     return viewpost('info');
    }
    public function customers()
    {
     return viewpost('customers');
    }
    public function Orders()
    {
     return viewpost('orders');
    }
    public function expenses
    ()
    {
     return viewpost('expenses');
    }
    public function handlers()
    {
     return viewpost('db_stats');

    }
     public function brand()
     {
      return viewpost('Brands');
     }
     public function Accounts()
     {
      return viewpost('Account');
     }
     public function AotuTatol()
     {
      return viewpost('AotuTatol');
     }
     public function printHelper()
     {
      return viewpost('printHelper');
     }


}