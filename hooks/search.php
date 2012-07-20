<?php
    function HookInline_keywordsSearchSearchbarbottomtoolbar()
    {
        global $lang, $inline_keywords_usertype, $inline_keywords_editable_fields;
        if(checkperm($inline_keywords_usertype))
            {
            ?>
            <div id="SearchBoxPanel" class="keywordPanel">
              <div class="SearchSpace">
                <h2><?php echo $lang["editfields"]; ?></h2>
                <p><?php echo $lang['keywordstoresource']; ?></p>
                
                <form id="manipulateKeywords">
                  <span class="wrap">
					<?php
				foreach($inline_keywords_editable_fields as $field)
					{
					$label_result = sql_query("select title from resource_type_field where ref = '$field'");
					$label = ($label_result[0]['title']);
					
                    echo "<p>";
                        echo "<label for='ref_$field'>$label</label>";
                        echo "<input id='ref_$field' name='ref_$field' class='SearchWidth'/>";
                    echo "</p>";
					} ?>
                  </span>
                  <input type="button" id="selectAllResourceButton" value="<?php echo $lang["selectall"]; ?>">
                  <input type="button" id="clearSelectedResourceButton" value="<?php echo $lang["unselectall"]; ?>">
                  <input type="button" id="submitSelectedResourceButton" value="<?php echo $lang["submitchanges"]; ?>">
                  <input type="button" id="archiveResourcesButton" value="<?php echo $lang["archiveresources"]; ?>">
                </form>
              </div>
            </div>
            <?php
        }
    }
    function HookInline_keywordsSearchAdditionalheaderjs()
        {
        global $baseurl, $inline_keywords_usertype, $inline_keywords_background_colour, $inline_keywords_clear_fields_on_submit, $inline_keywords_sticky_panel;
    if(checkperm($inline_keywords_usertype))
        { ?>
            <script type='text/javascript'>
                jQuery(document).ready(function() {
                    jQuery('form#manipulateKeywords label').each(function(){
                        if(jQuery(this.siblings(':text')).val()!==""){
                            this.hide();
                        }
                    });
                    <?php if($inline_keywords_sticky_panel)
						{ ?>
						var panelTop = jQuery('.keywordPanel').eq(0).offset().top;

						jQuery(window).scroll(function(){
							if(jQuery(window).scrollTop() > (panelTop - 20)){
								jQuery('.keywordPanel').css({'position':'fixed','top':'20px'});
							}else{
								jQuery('.keywordPanel').css({'position':'static','top':'20px'});
							}
						});
						<?php
						} ?>
                    
					jQuery('form#manipulateKeywords :text').focus(function(event){
                        jQuery(this).siblings('label').fadeOut('fast');
                    });

                    jQuery('form#manipulateKeywords :text').blur(function(event){
                        if(jQuery(this).val() === ""){
                            jQuery(this).siblings('label').fadeIn('fast');                            
                        }
                    });
                    
                    jQuery('.ResourcePanelShell, .ResourcePanelShellSmall').on('click', function(event) {
                        if(!(event.originalEvent.srcElement instanceof HTMLImageElement )){
                            //console.log(event.originalEvent.srcElement instance of HTMLImageElement);
                            jQuery(this).toggleClass('chosen');
                            jQuery('.ResourcePanel, .ResourcePanelSmall').css('border-color','');
                            jQuery('.chosen .ResourcePanel, .chosen .ResourcePanelSmall').css('border-color','<?php echo $inline_keywords_background_colour; ?>');
                        }
                    });
                    
                    jQuery('#clearSelectedResourceButton').on('click', function() {
                        jQuery('.chosen').removeClass('chosen');
                        jQuery('#newKeywordsForSelectedResources').val('');
                        jQuery('.ResourcePanel, .ResourcePanelSmall').css('border-color','');
                        jQuery('.chosen .ResourcePanel, .chosen .ResourcePanelSmall').css('border-color','<?php echo $inline_keywords_background_colour; ?>');
                    });
                    
                    jQuery('#selectAllResourceButton').on('click', function() {
                        jQuery('.ResourcePanelShell, .ResourcePanelShellSmall').addClass('chosen');
                        jQuery('.ResourcePanel, .ResourcePanelSmall').css('border-color','');
                        jQuery('.chosen .ResourcePanel, .chosen .ResourcePanelSmall').css('border-color','<?php echo $inline_keywords_background_colour; ?>');
                    });
                    
					jQuery('#archiveResourcesButton').on('click', function(){
                        resourceIds = jQuery.map(jQuery('.chosen'), function(a, b){
                            return jQuery(a).attr('id').replace('ResourceShell','');
                        }).join('+');
					    jQuery.ajax({
					      type: "POST",
					      url: "<?php echo $baseurl; ?>/plugins/inline_keywords/pages/archive_resources.php",
					      data: { refs: resourceIds  }
					    }).done(function( msg ) {
					      location.reload(true);
						  alert( "Deleted resources: " + msg );
					    });
						
					});
					
                    jQuery('#submitSelectedResourceButton').on('click', function() {
						var form_values = jQuery('form#manipulateKeywords').serialize();
                        resourceIds = jQuery.map(jQuery('.chosen'), function(a, b){
                            return jQuery(a).attr('id').replace('ResourceShell','');
                        }).join('+');
                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo $baseurl; ?>/plugins/inline_keywords/pages/add_keywords.php",
                            data: 'refs=' + resourceIds + '&' + form_values 
                        }).done(function( msg ) {
                            if(msg !== ''){alert( "Data Saved: " + msg );}
                            //jQuery(".keywordPanel").effect("highlight", {}, 3000);
                            jQuery(".keywordPanel").fadeTo("slow", 0.5, function () {
                                jQuery(".keywordPanel").fadeTo("slow", 1.0, function(){});
                            });
                            <?php if($inline_keywords_clear_fields_on_submit){
                                echo "jQuery('form#manipulateKeywords :text').val('');jQuery('form#manipulateKeywords label').show();";
                            }?>
                        });
                    });
                });
            </script>
        <?php }
    return true;
    }
?>