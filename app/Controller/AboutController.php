<?php

class AboutController extends Controller
{

    public $components = array('DebugKit.Toolbar');

    public function index()
    {
        $this->set('title_for_layout', 'はやりあんてな概要');

        //ブログURL登録フォームからの登録処理
        $Contacts = ClassRegistry::init('Contacts');
        if (isset($this->request->data['contact_title'])) {
            if (isset($this->request->data['contact_body'])) {
                if (isset($this->request->data['contact_email'])) {
                    $save_result = $Contacts->save(
                        array(
                            'Contacts' => array(
                                'title' => $this->request->data['contact_title'],
                                'body' => $this->request->data['contact_body'],
                                'email' => $this->request->data['contact_email']
                            )
                        )
                    );
                    $this->set('save_result', $save_result);
                }
            }
        }
    }


    public function sites()
    {

        $this->set('title_for_layout', '登録済サイト一覧');

        //ブログURL登録フォームからの登録処理
        $Blogs = ClassRegistry::init('Blogs');
        if (isset($this->request->data['blog_title'])) {
            if (isset($this->request->data['blog_url'])) {
                if (isset($this->request->data['blog_provider'])) {
                    if (strcmp($this->request->data['blog_provider'], "others") != 0) {

                        $save_result = $Blogs->save(
                            array(
                                'Blogs' => array(
                                    'title' => $this->request->data['blog_title'],
                                    'url' => $this->request->data['blog_url'],
                                    'provider' => $this->request->data['blog_provider']
                                )
                            )
                        );

                        $this->set('save_result', $save_result);
                        $this->set('blog_title', $this->request->data['blog_title']);
                        $this->set('blog_url', $this->request->data['blog_url']);
                    }
                }
            }
        }


        $blogs_datas_livedoor = $Blogs->find('all', array('conditions' => array('Blogs.provider' => 'livedoor')));
        $blogs_datas_fc2 = $Blogs->find('all', array('conditions' => array('Blogs.provider' => 'fc2')));
        $blogs_datas_ameblo = $Blogs->find('all', array('conditions' => array('Blogs.provider' => 'ameblo')));

        $this->set('blogs_datas_livedoor', $blogs_datas_livedoor);
        $this->set('blogs_datas_fc2', $blogs_datas_fc2);
        $this->set('blogs_datas_ameblo', $blogs_datas_ameblo);

        $this->set('num_of_blogs_livedoor', count($blogs_datas_livedoor));
        $this->set('num_of_blogs_fc2', count($blogs_datas_fc2));
        $this->set('num_of_blogs_ameblo', count($blogs_datas_ameblo));
    }

}