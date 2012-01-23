<?php

abstract class IceModelGeneratorHelper extends sfModelGeneratorHelper
{
  /**
   * Returns HTML code for an action link.
   *
   * @param string  $actionName The action name
   * @param array   $params     The parameters
   * @param boolean $pk_link    Whether to add a primary key link or not
   *
   * @return string HTML code
   */
  public function getLinkToAction($actionName, $params, $pk_link = false)
  {
    $params = array_merge(array('class' => 'btn large'), $params);
    $action = isset($params['action']) ? $params['action'] : 'List'.sfInflector::camelize($actionName);

    $url_params = $pk_link ? '?'.$this->getPrimaryKeyUrlParams() : '\'';

    return '[?php echo link_to(__(\''.$params['label'].'\', array(), \''.$this->getI18nCatalogue().'\'), \''.$this->getModuleName().'/'.$action.$url_params.', '.$this->asPhp($params['params']).') ?]';
  }

  public function linkToNew($params)
  {
    return '<li class="sf_admin_action_new">'. link_to(__($params['label'], array(), 'sf_admin'), '@'.$this->getUrlForAction('new'), $params['params']) .'</li>';
  }

  public function linkToDelete($object, $params)
  {
    if ($object->isNew())
    {
      return '';
    }

    $params['params'] = array_merge($params['params'], array('method' => 'delete', 'confirm' => !empty($params['confirm']) ? __($params['confirm'], array(), 'sf_admin') : $params['confirm']));
    return '<li class="sf_admin_action_delete">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('delete'), $object, $params['params']).'</li>';
  }

  public function linkToList($params)
  {
    if ($params['label'] == 'Back to list')
    {
      $params['label'] = '&#8592; Back to List';
    }
    return '<li class="sf_admin_action_list">'.link_to(__($params['label'], array(), 'sf_admin'), '@'.$this->getUrlForAction('list'), $params['params']).'</li>';
  }

  public function linkToSave($object, $params)
  {
    return '<li class="sf_admin_action_save"><input type="submit" class="btn success" value="'.__($params['label'], array(), 'sf_admin').'" /></li>';
  }

  public function linkToSaveAndAdd($object, $params)
  {
    if (!$object->isNew())
    {
      return '';
    }

    return '<li class="sf_admin_action_save_and_add"><input type="submit" class="btn" value="'.__($params['label'], array(), 'sf_admin').'" name="_save_and_add" /></li>';
  }

}
