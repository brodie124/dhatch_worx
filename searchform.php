<form role="search" method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<span class="sr-only">Search for:</span>
  <input type="search" name="s" value="<?php _e('Type in Search Phrase..', 'tt') ?>" onfocus="if(this.value=='<?php _e('Type in Search Phrase..', 'tt') ?>')this.value='';" onblur="if(this.value=='')this.value='<?php _e('Type in Search Phrase..', 'tt') ?>';" />
  <input type="submit" value="Search" id="search-submit" class="hide" />
</form>