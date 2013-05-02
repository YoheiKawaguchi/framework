<?php
class Blog_Controller_IndexController extends Core_Controller
{
    function indexAction()
    {
        // nothing to do here... redirect to showAction
        redirect('/blog/index/show/id/1');
    }

    function showAction()
    {
        // get blog entry id from URL (do not use $_GET)
        $id = $this->request->getQuery('id');
        
        // Class is auto loaded (No need to include/requre anymore)
        $tableBlog = new Blog_Model_BlogModel;
        
        // find a blog entry by its primary key
        $post = $tableBlog->find($id);
        
        // set variables for the view file
        $this->view->set('post',      $post[0]);
        $this->view->set('pageTitle', $post[0]['title']);

        // include the view file
        $this->view->render('Blog', 'show');
    }
}
