<?php
/**
 * This file is part of Tak-Me System.
 *
 * Copyright (c)2016-2017 PlusFive (https://www.plus-5.com)
 *
 * This software is released under the MIT License.
 * https://www.plus-5.com/licenses/mit-license
 */

namespace FixedForm\Lang;

/**
 * Japanese Languages for Tms.
 *
 * @license https://www.plus-5.com/licenses/mit-license  MIT License
 * @author  Taka Goto <www.plus-5.com>
 */
class Ja extends \P5\Lang
{
    protected $CONFIRM_SAVE_DATA = 'データを保存します。よろしいですか？';
    protected $CONFIRM_DELETE_DATA = "データを削除します。取消はできません\nよろしいですか？";

    protected $SUCCESS_SAVED = 'データを更新しました。';
    protected $SUCCESS_REMOVED = 'データを削除しました。';

    protected $FAILED_SAVE = 'データ更新に失敗しました。';
    protected $FAILED_REMOVED = '削除できませんでした。';
}
