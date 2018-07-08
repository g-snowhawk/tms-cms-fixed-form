<?php
/**
 * This file is part of Tak-Me CMS system.
 *
 * @author  Taka Goto <www.plus-5.com>
 * @copyright (c)2018 PlusFive (https://www.plus-5.com)
 */
namespace FixedForm;

class Receive extends Response
{
    public function save()
    {
        $message = 'SUCCESS_SAVED';
        $status = 0;
        $options = [];
        $response = [[$this, 'redirect'], 'fixed-form~response'];

        if (!parent::save()) {
            $message = 'FAILED_SAVE';
            $status = 1;
            $options = [
                [[$this->view, 'bind'], ['err', $this->app->err]],
            ];
            $response = [[$this, 'edit'], null];
        }

        $this->postReceived(\P5\Lang::translate($message), $status, $response, $options);
    }

    /**
     * Remove the data receive interface.
     */
    public function remove()
    {
        $message = 'SUCCESS_REMOVED';
        $status = 0;
        $options = [];
        $response = [[$this, 'redirect'], 'fixed_form~response'];

        if (!parent::remove()) {
            $message = 'FAILED_REMOVE';
            $status = 1;
        }

        $this->postReceived(\P5\Lang::translate($message), $status, $response, $options);
    }
}
