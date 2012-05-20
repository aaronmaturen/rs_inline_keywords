<?php
    function HookInline_keywordsSearchSearchbarbottomtoolbar()
    {
        global $lang, $inline_keywords_usertype;
        if(checkperm($inline_keywords_usertype))
            {
            ?>
            <div id="SearchBoxPanel" class="keywordPanel">
              <div class="SearchSpace">
                <h2><?php echo $lang["addkeywords"]; ?></h2>
                <p><?php echo $lang['keywordstoresource']; ?></p>
                
                <form id="manipulateKeywords">
                  <input id="newKeywordsForSelectedResources" class="SearchWidth"/>
                  <input type="button" id="selectAllResourceButton" value="<?php echo $lang["selectall"]; ?>">
                  <input type="button" id="clearSelectedResourceButton" value="<?php echo $lang["unselectall"]; ?>">
                  <input type="button" id="submitSelectedResourceButton" value="<?php echo $lang["addkeywords"]; ?>">
                </form>
              </div>
            </div>
            <?php
        }
    }
    function HookInline_keywordsSearchAdditionalheaderjs()
        {
        global $baseurl, $inline_keywords_usertype, $inline_keywords_background_colour;
    if(checkperm($inline_keywords_usertype))
        { ?>
            <script type='text/javascript'>
                jQuery(document).ready(function() {
                    jQuery('.ResourcePanelShell, .ResourcePanelShellSmall').on('click', function() {
                        jQuery(this).toggleClass('chosen');
                        jQuery('.ResourcePanel, .ResourcePanelSmall').css('border-color','');
                        jQuery('.chosen .ResourcePanel, .chosen .ResourcePanelSmall').css('border-color','<?php echo $inline_keywords_background_colour; ?>');
                    });
                    
                    jQuery('.ResourcePanelShell, .ResourcePanelShellSmall').on('click','a',function(event){event.stopPropagation();});
                    
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
                    
                    jQuery('#submitSelectedResourceButton').on('click', function() {
                        resourceIds = jQuery.map(jQuery('.chosen'), function(a, b){
                            return jQuery(a).attr('id').replace('ResourceShell','');
                        }).join('+');
                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo $baseurl; ?>/plugins/inline_keywords/pages/add_keywords.php",
                            data: { refs: resourceIds, keywords: jQuery('#newKeywordsForSelectedResources').val().replace(/ /g,'+') }
                        }).done(function( msg ) {
                            if(msg !== ''){alert( "Data Saved: " + msg );}
                            //jQuery(".keywordPanel").effect("highlight", {}, 3000);
                            jQuery(".keywordPanel").fadeTo("slow", 0.5, function () {
                                jQuery(".keywordPanel").fadeTo("slow", 1.0, function(){});
                            });
                        });
                    });
                });
            </script>
        <?php }
    return true;
    }
?>