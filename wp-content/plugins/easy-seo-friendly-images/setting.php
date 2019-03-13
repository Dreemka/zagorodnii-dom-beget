<div class="seo_friendly_wrap">
<?php 

	if (current_user_can( 'manage_options' ) ) {
		if(isset($_POST['Submit'])){
				if ( ! isset( $_POST['name_of_nonce_field'] ) 
					|| ! wp_verify_nonce( $_POST['name_of_nonce_field'], 'name_of_my_action' ) 
				) {
				   print 'Sorry, your nonce did not verify.';
				   exit;
				} else {
				update_option('alt_val', sanitize_text_field($_POST['alt_val']));
				update_option('title_val', sanitize_text_field($_POST['title_val']));
				update_option('override_existing_alt', intval($_POST['override_existing_alt']));
				update_option('override_existing_title', intval($_POST['override_existing_title']));
			}
		} 
	}
?>
<div class="col-md-8">
<h2>Seo Friendly Images Setting</h2>
</div>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" >
<?php wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' ); ?>
<div class="col-md-10">
    <div class="row">
        <div class="col-md-4">
            <span>Alt Value</span>
        </div>
        <div class="col-md-6">
           
        <input name="alt_val" class="form-control alt_val" value="<?php echo get_option('alt_val'); ?>"/>
             <span class="spac-holder-desc">Click to add a space holder</span>
             <span class="add-space-holder" data-input="alt_val" data-sh="[File Name]">File Name |</span>
             <span class="add-space-holder" data-input="alt_val"  data-sh="[Post Title]">Post Title |</span>
             <span class="add-space-holder" data-input="alt_val"  data-sh="[Categories]">Categories |</span>
             <span class="add-space-holder" data-input="alt_val"  data-sh="[Tags]">Tags </span>
        </div>
    </div>
    <script>
	jQuery(document).ready(function(e) {
        jQuery('.add-space-holder').click(function(e) {
            jQuery('.' + jQuery(this).attr('data-input')).val(jQuery('.' + jQuery(this).attr('data-input')).val() + ' ' + jQuery(this).attr('data-sh'));
        });
    });
	</script>
    <div class="row">
     <div class="col-md-4">
    	<span>Override Existing Alt</span>
    </div>
    <div class="col-md-6">
    	<select name="override_existing_alt" class="form-control">
        	<option value="1" <?php if(get_option('override_existing_alt') ==1){ echo "selected"; } ?> >Yes </option>
            <option value="0" <?php if(get_option('override_existing_alt') ==0){ echo "selected"; } ?> >No </option>
        </select>
    </div>
    </div>
    <div class="row">
    <div class="col-md-4">
    	<span>Title Value</span>
    </div>
    <div class="col-md-6">
    	 <input name="title_val" class="form-control title_val" value="<?php echo get_option('title_val'); ?>"/>
             <span class="spac-holder-desc">Click to add a space holder</span>
             <span class="add-space-holder" data-input="title_val" data-sh="[File Name]">File Name |</span>
             <span class="add-space-holder" data-input="title_val"  data-sh="[Post Title]">Post Title |</span>
             <span class="add-space-holder" data-input="title_val"  data-sh="[Categories]">Categories |</span>
             <span class="add-space-holder" data-input="title_val"  data-sh="[Tags]">Tags </span>
    </div>
    </div>
    <div class="row">
    <div class="col-md-4">
    	<span>Override Existing Title</span>
    </div>
    <div class="col-md-6">
    	<select name="override_existing_title" class="form-control">
        	<option value="1" <?php if(get_option('override_existing_title') ==1){ echo "selected"; } ?> >Yes </option>
            <option value="0" <?php if(get_option('override_existing_title') ==0){ echo "selected"; } ?> >No </option>
        </select>
    </div>
   </div>
  <div class="row"> 
  <div class="col-md-4"></div>
   <div class="col-md-6">
        <input type="submit" class="btn btn-info" name="Submit" value="<?php _e('Update Options' ) ?>" />
    </div>
   </div>
</div>


</form>
</div>