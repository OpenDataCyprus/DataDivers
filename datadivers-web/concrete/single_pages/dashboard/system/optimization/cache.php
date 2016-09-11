<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<form method="post" class="ccm-dashboard-content-form" action="<?php echo $view->url('/dashboard/system/optimization/cache', 'update_cache')?>">
    <?php echo $this->controller->token->output('update_cache')?>

    <fieldset style="margin-bottom: 15px">
    <legend style="display: inline-block; margin-bottom: 0; width: auto; font-size: 14px; font-weight: bold" class="launch-tooltip" data-placement="right" title="<?php echo t('Stores the output of blocks which support block caching')?>"><?php echo t('Block Cache')?></legend>

    <div class="radio">
        <label>
            <input type="radio" name="ENABLE_BLOCK_CACHE" value="0" <?php if (!Config::get('concrete.cache.blocks')) { ?> checked <?php  } ?> />
            <?php echo t('Off - Good for development of custom blocks.')?>
        </label>
    </div>

    <div class="radio">
        <label>
            <input type="radio" name="ENABLE_BLOCK_CACHE" value="1" <?php if (Config::get('concrete.cache.blocks')) { ?> checked <?php  } ?> />
            <?php echo t('On - Helps speed up a live site.')?>
        </label>
    </div>
    </fieldset>

    <fieldset style="margin-bottom: 15px">
        <legend style="display: inline-block; margin-bottom: 0; width: auto; font-size: 14px; font-weight: bold" class="launch-tooltip" data-placement="right" title="<?php echo t('Caches the output of customized theme stylesheets for faster loading. Turn off if you are editing LESS files in your theme directly.')?>"><?php echo t('Theme CSS Cache.')?></legend>

        <div class="radio">
            <label>
                <input type="radio" name="ENABLE_THEME_CSS_CACHE" value="0" <?php if (!Config::get('concrete.cache.theme_css')) { ?> checked <?php  } ?> />
                <span><?php echo t('Off - Good for active theme development when using LESS files.')?></span>
            </label>
        </div>

        <div class="radio">
            <label>
                <input type="radio" name="ENABLE_THEME_CSS_CACHE" value="1" <?php  if (Config::get('concrete.cache.theme_css')) { ?> checked <?php  } ?> />
                <span><?php echo t('On - Helps speed up a live site.')?></span>
            </label>
        </div>
    </fieldset>

    <fieldset style="margin-bottom: 15px">
        <legend style="display: inline-block; margin-bottom: 0; width: auto; font-size: 14px; font-weight: bold" class="launch-tooltip" data-placement="right" title="<?php echo t('Determines whether compiled LESS stylesheets should output as compressed CSS. Uncompressed stylesheets are slightly larger but easier to read.')?>"><?php echo t('Compress LESS Output.')?></legend>

        <div class="radio">
            <label>
                <input type="radio" name="COMPRESS_THEME_PREPROCESSOR_OUTPUT" value="0" <?php if (!Config::get('concrete.theme.compress_preprocessor_output')) { ?> checked <?php  } ?> />
                <span><?php echo t('Off - Good for debugging generated CSS output.')?></span>
            </label>
            <br>
            <label><input type="checkbox" name="GENERATE_LESS_SOURCEMAP" value="1" <?php if (Config::get('concrete.theme.generate_less_sourcemap')) { ?> checked <?php  } ?> > <?php echo t('enable source maps in generated CSS files'); ?></label>
        </div>

        <div class="radio">
            <label>
                <input type="radio" name="COMPRESS_THEME_PREPROCESSOR_OUTPUT" value="1" <?php  if (Config::get('concrete.theme.compress_preprocessor_output')) { ?> checked <?php  } ?> />
                <span><?php echo t('On - Helps speed up a live site.')?></span>
            </label>
        </div>
    </fieldset>


    <fieldset style="margin-bottom: 15px">
        <legend style="display: inline-block; margin-bottom: 0; width: auto; font-size: 14px; font-weight: bold" class="launch-tooltip" data-placement="right" title="<?php echo t('Stores the generation of CSS and JavaScript assets')?>"><?php echo t('CSS and JavaScript Cache')?></legend>

        <div class="radio">
            <label>
                <input type="radio" name="ENABLE_ASSET_CACHE" value="0" <?php if (!Config::get('concrete.cache.assets')) { ?> checked <?php  } ?> />
                <span><?php echo t('Off - Good for active block and site development.')?></span>
            </label>
        </div>

        <div class="radio">
            <label>
                <input type="radio" name="ENABLE_ASSET_CACHE" value="1" <?php  if (Config::get('concrete.cache.assets')) { ?> checked <?php  } ?> />
                <span><?php echo t('On - Helps speed up a live site.')?></span>
            </label>
        </div>
    </fieldset>

    <fieldset style="margin-bottom: 15px">
        <legend style="display: inline-block; margin-bottom: 0; width: auto; font-size: 14px; font-weight: bold" class="launch-tooltip" data-placement="right" title="<?php echo t('Stores the location and existence of source code files')?>"><?php echo t('Overrides Cache')?></legend>

        <div class="radio">
            <label>
                <input type="radio" name="ENABLE_OVERRIDE_CACHE" value="0" <?php  if (!Config::get('concrete.cache.overrides')) { ?> checked <?php  } ?> />
                <span><?php echo t('Off - Good for development.')?></span>
            </label>
        </div>

        <div class="radio">
            <label>
                <input type="radio" name="ENABLE_OVERRIDE_CACHE" value="1" <?php  if (Config::get('concrete.cache.overrides')) { ?> checked <?php  } ?> />
                <span><?php echo t('On - Helps speed up a live site.')?></span>
            </label>
        </div>
    </fieldset>

    <fieldset style="margin-bottom: 15px">
        <legend style="display: inline-block; margin-bottom: 0; width: auto; font-size: 14px; font-weight: bold" class="launch-tooltip" data-placement="right" title="<?php echo t('Stores the output of an entire page')?>"><?php echo t('Full Page Caching')?></legend>
        <div class="radio">
            <label>
                <input type="radio" name="FULL_PAGE_CACHE_GLOBAL" value="0" <?php  if (!Config::get('concrete.cache.pages')) { ?> checked <?php  } ?> />
                <span><?php echo t('Off - Turn it on by hand for specific pages.')?></span>
            </label>
        </div>

        <div class="radio">
            <label>
                <input type="radio" name="FULL_PAGE_CACHE_GLOBAL" value="blocks" <?php  if (Config::get('concrete.cache.pages') == 'blocks') { ?> checked <?php  } ?> />
                <span><?php echo t('On - If blocks on the particular page allow it.')?></span>
            </label>
        </div>

        <div class="radio">
            <label>
                <input type="radio" name="FULL_PAGE_CACHE_GLOBAL" value="all" <?php  if (Config::get('concrete.cache.pages') == 'all') { ?> checked <?php  } ?> />
                <span><?php echo t('On - In all cases.')?></span>
            </label>
        </div>
    </fieldset>

    <fieldset>
        <legend style="display: inline-block; margin-bottom: 0; width: auto; font-size: 14px; font-weight: bold" class="launch-tooltip" data-placement="right" title="<?php echo t('Sets the amount of time to store the page output before generating a new version')?>"><?php echo t('Expire Pages from Cache')?></legend>

        <div class="radio">
          <label>
              <input type="radio" name="FULL_PAGE_CACHE_LIFETIME" value="default" <?php  if (Config::get('concrete.cache.full_page_lifetime') == 'default') { ?> checked <?php  } ?> />
              <span><?php echo t('Every %s (default setting).', Loader::helper('date')->describeInterval(Config::get('concrete.cache.lifetime')))?></span>
          </label>
        </div>

        <div class="radio">
            <label>
                <input type="radio" name="FULL_PAGE_CACHE_LIFETIME" value="forever" <?php  if (Config::get('concrete.cache.full_page_lifetime') == 'forever') { ?> checked <?php  } ?> />
                <span><?php echo t('Only when manually removed or the cache is cleared.')?></span>
            </label>
        </div>

        <div class="radio">
            <label>
                <input type="radio" name="FULL_PAGE_CACHE_LIFETIME" value="custom" style="margin-bottom:1px; vertical-align:text-bottom;" <?php if (Config::get('concrete.cache.full_page_lifetime') == 'custom') { ?> checked <?php  } ?> />
                <span>
                    <?php echo t('Every ')?>
                    <input type="text" name="FULL_PAGE_CACHE_LIFETIME_CUSTOM" value="<?php echo h(Config::get('concrete.cache.full_page_lifetime_value')) ?>" size="4" />
                    <?php echo t(' minutes.')?>
                </span>
            </label>
        </div>
    </fieldset>

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button class="pull-right btn btn-primary" type="submit" ><?php echo t('Save')?></button>
        </div>
    </div>

</form>

<script type="text/javascript">
	ccm_settingsSetupCacheForm = function() {
		var obj = $('input[name=ENABLE_CACHE]:checked');
		if (obj.val() == 0) {
			$('div.ccm-cache-settings-full-page input').attr('disabled', true);
			$('input[name=FULL_PAGE_CACHE_LIFETIME][value=default]').attr('checked', true);
		} else {
			$('div.ccm-cache-settings-full-page input').attr('disabled', false);
		}
		var obj2 = $('input[name=FULL_PAGE_CACHE_LIFETIME]:checked');
		if (obj2.val() == 'custom') {
			$('input[name=FULL_PAGE_CACHE_LIFETIME_CUSTOM]').attr('disabled', false);
		} else {
			$('input[name=FULL_PAGE_CACHE_LIFETIME_CUSTOM]').attr('disabled', true);
			$('input[name=FULL_PAGE_CACHE_LIFETIME_CUSTOM]').val('');
		}
	}

	$(function(){
		$("input[name='CONTENTS_TXT_EDITOR_MODE']").each(function(i,el){
			el.onchange=function(){isTxtEditorModeCustom();}
		})
		$("input[name=ENABLE_CACHE]").click(function() {
			ccm_settingsSetupCacheForm();
		});
		$("input[name=FULL_PAGE_CACHE_LIFETIME]").click(function() {
			ccm_settingsSetupCacheForm();
		});
		$("input[name=FULL_PAGE_CACHE_LIFETIME][value=custom]").click(function() {
			$('input[name=FULL_PAGE_CACHE_LIFETIME_CUSTOM]').get(0).focus();
		});
		ccm_settingsSetupCacheForm();
	});
	function isTxtEditorModeCustom(){
		if($("input[name='CONTENTS_TXT_EDITOR_MODE']:checked").val()=='CUSTOM'){
			$('#cstmEditorTxtAreaWrap').css('display','block');
		}else{
			$('#cstmEditorTxtAreaWrap').css('display','none');
		}
	}
</script>
