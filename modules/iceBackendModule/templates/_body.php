<?php
/**
 * @var  sfContext  $sf_context
 *
 * @var  array   $items
 * @var  array   $categories
 * @var  string  $content
 *
 * @var  string  $module_link
 * @var  string  $module_link_name
 *
 * @var  string  $action_link
 * @var  string  $action_link_name
 */
?>

<?php include_partial('iceBackendModule/menu', array('items' => $items, 'categories' => $categories)); ?>

<div class="container">
  <div class="content">

    <ul class="breadcrumb">
      <li><a href='<?php echo url_for('@homepage'); ?>'><?php echo iceBackendModule::getProperty('site', 'Dashboard'); ?></a></li>
      <?php if ($sf_context->getModuleName() != 'iceBackendModule' && $sf_context->getActionName() != 'dashboard'): ?>
        <li>
          <span class="divider">/</span>
          <?php echo null !== $module_link ? link_to(__(ucwords($module_link_name), array(), 'ice_backend_plugin'), $module_link) : ucwords($module_link_name); ?>
        </li>
        <?php if (null != $action_link): ?>
          <li>
            <span class="divider">/</span>
            <?php echo link_to(__(ucwords($action_link_name), array(), 'ice_backend_plugin'), $action_link); ?>
          </li>
        <?php endif ?>
      <?php endif; ?>
    </ul>

    <?php echo $content; ?>
  </div>

  <?php include_partial('iceBackendModule/footer'); ?>
</div>
