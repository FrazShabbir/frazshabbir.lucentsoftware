<?php defined('\ABSPATH') || exit; ?>
<input type="text" class="input-sm col-md-4" ng-model="query_params.<?php echo $module_id; ?>.price_from" ng-init="query_params.<?php echo $module_id; ?>.price_from = ''" placeholder="<?php _e('Min. price', 'content-egg'); ?>" />
<input type="text" class="input-sm col-md-4" ng-model="query_params.<?php echo $module_id; ?>.price_to" ng-init="query_params.<?php echo $module_id; ?>.price_to = ''" placeholder="<?php _e('Max. price', 'content-egg'); ?>" />
