<?php
/**
 * This file is part of Tak-Me CMS system.
 *
 * @author  Taka Goto <www.plus-5.com>
 * @copyright (c)2018 PlusFive (https://www.plus-5.com)
 */
namespace plugin\FixedForm;
use plugin\FixedForm;

class Response extends FixedForm
{
    /**
     * Object Constructer.
     */
    public function __construct()
    {
        $params = func_get_args();
        call_user_func_array('parent::__construct', $params);

        $this->view->bind(
            'header',
            ['title' => 'Fixed Format Manager', 'id' => 'fixedform', 'class' => 'fixedform']
        );
    }

    public function defaultView()
    {
        $fixed_forms = $this->db->select('id,title,tags,create_date,modify_date', 'fixed_form', 'WHERE sitekey = ? ORDER BY tags', [$this->cms->siteID]);
        $this->view->bind('fixedForms', $fixed_forms);

        $this->view->bind('apps', $this->cms);

        $form = $this->view->param('form');
        $form['confirm'] = \P5\Lang::translate('CONFIRM_DELETE_DATA');
        $this->view->bind('form', $form);

        $template = 'cms/fixed_form/default.tpl';
        $this->view->render($template);
    }

    public function edit()
    {
        $id = $this->request->param('id');

        if ($this->request->method === 'post') {
            $post = $this->request->POST();
        } else {
            $columns = ['id','title','content','tags','fgcolor','bgcolor','create_date','modify_date'];
            $post = $this->db->get(
                implode(',', $columns),
                'fixed_form',
                'id = ? AND sitekey = ?',
                [$id, $this->cms->siteID]
            );
        }
        $this->view->bind('post', $post);

        $this->view->bind('apps', $this->cms);

        $form = $this->view->param('form');
        $form['confirm'] = \P5\Lang::translate('CONFIRM_SAVE_DATA');
        $this->view->bind('form', $form);

        $template = 'cms/fixed_form/edit.tpl';
        $this->view->render($template);
    }

    public function fixedFormData()
    {
        $data = $this->db->get('title,content', 'fixed_form', 'id = ?', [$this->request->param('id')]);
        echo json_encode($data);
    }
}
