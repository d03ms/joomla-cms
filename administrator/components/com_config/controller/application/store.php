<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_config
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Refresh Help Controller for global configuration
 *
 * @since  3.2
 */
class ConfigControllerApplicationStore extends JControllerBase
{
    /**
     * Method to GET permission value and give it to the model for storing in database.
     *
     * @return  JSON
     *
     * @since   >3.5
     */
    public function execute()
    {
        // Check if the user is authorized to do this.
        if (!JFactory::getUser()->authorise('core.admin'))
        {
            $this->app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'));
            $this->app->redirect('index.php');
        }

        // Get Post DATA
        $permissions = array(
            'component' => $this->input->get->get('comp'),
            'action' => $this->input->get->get('action'),
            'rule' => $this->input->get->get('rule'),
            'value' => $this->input->get->get('value'),
            'title' => $this->input->get->get('title','', 'RAW')
        );

        if(!(substr($permissions['component'], -6) == '.false')){
            // Load Permissions from Session and send to Model
            $model = new ConfigModelApplication;
            $response = $model->storePermissions($permissions);
            echo new JResponseJson(json_encode($response));
        }else{
            echo new JResponseJson(json_encode(false), 0);
        }
    }
}