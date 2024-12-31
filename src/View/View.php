<?php

namespace SecTheater\View;

class View
{
    public static function make($view, $params = [])
    {
        $baseContent = self::getBaseContent();
        
        $viewContent = self::getViewContent($view, params: $params);

            echo $viewContent;
        
        //   echo str_replace('{{content}}', $viewContent, $baseContent);
        
        // if($view == 'items')
        // {
           
        //     echo str_replace('{{script}}', $baseContentscr ,  $viewContent );
             
        // }
       
     }

     public static function postMake($view, $params = [])
     {
        $baseContentscr=self::getBaseContentScr();

        $viewContent = self::getPostContent($view, params: $params);
        
         echo str_replace('{{script}}', $viewContent, $baseContentscr);


     }
    protected static function getBaseContent()
    {
        ob_start();

        include view_path() . 'layouts/main.php';

        return ob_get_clean();
    }
    protected static function getBaseContentScr()
    {
        ob_start();
        include view_path() . 'layouts/script.php';
        return ob_get_clean();
       
    }

    public static function makeError($error)
    {
        self::getViewContent($error, true);
    }

    protected static function getViewContent($view, $isError = false, $params = [])
    {
        $path = $isError ? view_path() . 'errors/' : view_path();

        if (str_contains($view, '.')) {
            $views = explode('.', $view);

            foreach ($views as $view) {
                if (is_dir($path . $view)) {
                    $path = $path . $view . '/';
                }
            }
            $view = $path . end($views) . '.php';
        } else {
            $view = $path . $view . '.php';
        }

        extract($params);

        if ($isError) {
            include $view;
        } else {
             ob_start();

            include $view;
    
             return ob_get_clean();

        }
    }
    protected static function getPostContent($view, $isError = false, $params = [])
    {
        $path = $isError ? post_path() . 'errors/' : post_path();
       

        if (str_contains($view, '.')) {
            $views = explode('.', $view);

            foreach ($views as $view) {
                if (is_dir($path . $view)) {
                    $path = $path . $view . '/';
                }
            }
             $view = $path . end($views) . '.php';
           
        } else {
            $view = $path . $view . '.php';
        }

        extract($params);

        if ($isError) {
            include $view;
        } else {
            ob_start();
            
            include $view;

            return ob_get_clean();
        }
    }
}