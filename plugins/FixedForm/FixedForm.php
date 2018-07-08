<?php
/**
 * This file is part of Tak-Me CMS system.
 *
 * @author  Taka Goto <www.plus-5.com>
 * @copyright (c)2018 PlusFive (https://www.plus-5.com)
 */
class FixedForm extends \Tms\Plugin
{
    /**
     * instance of Tms\Cms
     *
     * @var object
     */
    protected $cms;

    /**
     * Object Constructer.
     */
    public function __construct()
    {
        $params = func_get_args();
        call_user_func_array('parent::__construct', $params);

        if (!empty($this->session->param('current_site'))) {
            $this->cms = new \Tms\Cms\Section($this->app);
        }
    }

    public function init()
    {
        parent::init();
    }

    protected function save()
    {
        $post = $this->request->POST();

        $valid = [];
        $valid[] = ['vl_title', 'title', 'empty'];

        if (!$this->validate($valid)) {
            return false;
        }

        $table_name = 'fixed_form';
        $skip = ['id', 'sitekey', 'userkey', 'create_date', 'modify_date'];
        $save = $this->createSaveData($table_name, $post, $skip);

        $save['sitekey'] = $this->cms->siteID;
        $save['userkey'] = $this->uid;

        $this->db->begin();

        if (empty($post['id'])) {
            $raw = ['create_date' => 'CURRENT_TIMESTAMP'];
            if (false !== $result = $this->db->insert($table_name, $save, $raw)) {
                $post['id'] = $this->db->lastInsertId(null, 'id');
            }
        }
        else {
            $result = $this->db->update($table_name, $save, 'id = ?', [$post['id']]);
        }

        if (false !== $result) {
            $modified = ($result > 0) ? $this->db->modified($table_name, 'id = ?', [$post['id']]) : true;
            if ($modified) {
                if ($result !== 0) {
                    // After save the data
                    $mode = 'cms.template.receive:rebuild-style-sheets';
                    $result = true;
                    if (!empty($mode)) {
                        list($instance, $function, $arguments) = $this->app->instance($mode);
                        $instance->init();
                        $result = call_user_func_array([$instance, $function], (array)$arguments);
                    }

                    if ($result !== false) {
                        return $this->db->commit();
                    }
                }
                else {
                    $this->app->err['vl_nochange'] = 1;
                }
            }
        }
        $this->db->rollback();

        return false;
    }

    public function remove()
    {
        $id = $this->request->param('delete');

        $this->db->begin();
        if (false !== $this->db->delete('fixed_form', 'id = ?', [$id])) {
            $this->app->logger->log("Remove the fixed form `{$id}'", 101);

            return $this->db->commit();
        }
        trigger_error($this->db->error());
        $this->db->rollback();

        return false;
    }

    public function fixedFormList($class, $tags = '', $columns = '*')
    {
        $fixed_forms = $this->db->select($columns, 'fixed_form', 'WHERE sitekey = ? AND tags = ?', [$this->cms->siteID, $tags]);

        return $fixed_forms;
    }

    public function beforeRendering($caller)
    {
        switch ($caller) {
            case 'Tms\\Cms\\Entry\\Response':
                $fixed_forms = $this->db->select('id,title', 'fixed_form', 'WHERE sitekey = ? AND tags = ?', [$this->cms->siteID, '定型文']);
                $this->view->bind('fixedForms', $fixed_forms);
                break;
        }
    }
}
