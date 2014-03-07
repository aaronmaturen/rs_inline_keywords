<?php
    function HookInline_keywordsAllAdditionalheaderjs()
        {
        global $baseurl, $inline_keywords_usertype, $inline_keywords_background_colour, $inline_keywords_clear_fields_on_submit, $inline_keywords_sticky_panel;
    if(checkperm($inline_keywords_usertype))
        { ?>
            <script type='text/javascript'>
                jQuery(window).load(function() {
		    console.dir(jQuery('body'));
                    jQuery('form#manipulateKeywords label').each(function(){
                        if(jQuery(this).siblings(':text').val()!==""){
                            this.hide();
                        }
                    });
                    <?php if($inline_keywords_sticky_panel)
						{ ?>
						jQuery('#UICenter').scroll(function(){
							if(jQuery('.keywordPanel')){
								if((jQuery('#SearchBoxPanel').offset().top + jQuery('#SearchBoxPanel').height()) < 15){
									jQuery('.keywordPanel').css({'position':'fixed','top':'20px'});
								}else{
									jQuery('.keywordPanel').css({'position':'static','top':'20px'});
								}
							}
						});
						<?php
						} ?>
                    jQuery('body').on('focus', 'form#manipulateKeywords :text', function(event){
                        jQuery(this).siblings('label').fadeOut('fast');
                    });

                    jQuery('body').on('blur', 'form#manipulateKeywords :text', function(event){
                        if(jQuery(this).val() === ""){
                            jQuery(this).siblings('label').fadeIn('fast');                            
                        }
                    });
                    
                    jQuery('body').on('click', '.ResourcePanelShell, .ResourcePanelShellSmall', function(event) {
                        if(!(event.originalEvent.srcElement instanceof HTMLImageElement )){
                            //console.log(event.originalEvent.srcElement instance of HTMLImageElement);
                            jQuery(this).toggleClass('chosen');
                            jQuery('.ResourcePanel, .ResourcePanelSmall').css('border-color','');
                            jQuery('.chosen .ResourcePanel, .chosen .ResourcePanelSmall').css('border-color','<?php echo $inline_keywords_background_colour; ?>');
                        }
                    });
                    
                    jQuery('body').on('click', '#clearSelectedResourceButton', function() {

                        jQuery('.chosen').removeClass('chosen');
                        jQuery('#newKeywordsForSelectedResources').val('');
                        jQuery('.ResourcePanel, .ResourcePanelSmall').css('border-color','');
                        jQuery('.chosen .ResourcePanel, .chosen .ResourcePanelSmall').css('border-color','<?php echo $inline_keywords_background_colour; ?>');
                    });
                    
                    jQuery('body').on('click', '#selectAllResourceButton', function() {
                        jQuery('.ResourcePanelShell, .ResourcePanelShellSmall').addClass('chosen');
                        jQuery('.ResourcePanel, .ResourcePanelSmall').css('border-color','');
                        jQuery('.chosen .ResourcePanel, .chosen .ResourcePanelSmall').css('border-color','<?php echo $inline_keywords_background_colour; ?>');
                    });
                    
					jQuery('body').on('click', '#archiveResourcesButton', function(){
                        resourceIds = jQuery.map(jQuery('.chosen'), function(a, b){
                            return jQuery(a).attr('id').replace('ResourceShell','');
                        }).join('+');
					    jQuery.ajax({
					      type: "POST",
					      url: "<?php echo $baseurl; ?>/plugins/inline_keywords/pages/archive_resources.php",
					      data: { refs: resourceIds  }
					    }).done(function( msg ) {
					      location.reload(true);
						  //alert( "Deleted resources: " + msg );
					    });
						
					});
					
                    jQuery('body').on('click', '#submitSelectedResourceButton', function() {
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
