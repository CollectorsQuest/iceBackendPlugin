[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<div id="sf_admin_container">
  [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]

  <div id="sf_admin_header">
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_header', array('pager' => $pager)) ?]
  </div>

  <?php if ($this->configuration->hasFilterForm()): ?>
    [?php include_partial('<?php echo $this->getModuleName() ?>/filters', array('form' => $filters, 'configuration' => $configuration)) ?]
  <?php endif; ?>

  <div class="row">
    <div class="span15">
      <h1>
        [?php echo <?php echo $this->getI18NString('list.title') ?> ?]
        <small>
          &#8212;
          [?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'ice_backend_plugin') ?]
          [?php if ($pager->haveToPaginate()): ?]
            [?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'ice_backend_plugin') ?]
          [?php endif; ?]
        </small>
      </h1>
    </div>
    [?php if ($pager->haveToPaginate()): ?]
    <div class="span5">
      [?php include_partial('<?php echo $this->getModuleName() ?>/pagination_basic', array('pager' => $pager)) ?]
    </div>
    [?php endif; ?]
  </div>

  <div id="sf_admin_content">
  <?php if ($this->configuration->getValue('list.batch_actions')): ?>
    <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'batch')) ?]" method="post">
  <?php endif; ?>
    [?php include_partial('<?php echo $this->getModuleName() ?>/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?]
    <div class="row">
      <div class="span10" style="text-align: left;">
        &nbsp;
        [?php include_partial('<?php echo $this->getModuleName() ?>/list_batch_actions', array('helper' => $helper)) ?]
      </div>
      <div class="span10" style="text-align: right;">
        &nbsp;
        [?php include_partial('<?php echo $this->getModuleName() ?>/list_actions', array('helper' => $helper)) ?]
      </div>
    </div>
    [?php if ($pager->haveToPaginate()): ?]
      <hr/>
      <div class="row">
        <div class="span10" style="font-size: 230%;">
          <strong>[?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'ice_backend_plugin') ?]</strong>
          [?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'ice_backend_plugin') ?]
        </div>
        <div class="span10">
          [?php include_partial('<?php echo $this->getModuleName() ?>/pagination', array('pager' => $pager)) ?]
        </div>
      </div>
    [?php endif; ?]
  <?php if ($this->configuration->getValue('list.batch_actions')): ?>
    </form>
  <?php endif; ?>
  </div>

  <div id="sf_admin_footer">
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_footer', array('pager' => $pager)) ?]
  </div>
</div>
