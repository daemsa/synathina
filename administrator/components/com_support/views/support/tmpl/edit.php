<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_support
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<form action="<?php echo JRoute::_('index.php?option=com_support&layout=edit&id=' . (int) $this->item->id); ?>" method="post" id="adminForm" name="adminForm">
	<div class="form-horizontal">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_SUPPORT_TYPE_DETAILS'); ?></legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="support.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>