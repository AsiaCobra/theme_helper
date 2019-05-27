// Change the previewed URL to the selected page when changing the page_for_posts.
 
$(document).ready(function(){
    wp.customize( 'page_for_posts', function( setting ) { 
        setting.bind( function( pageId ) { 
            pageId = parseInt( pageId, 10 ); 
            if ( pageId > 0 ) {    api.previewer.previewUrl.set( api.settings.url.home + '?page_id=' + pageId ); 
            } 
        });
    });
    // console.log( wp.customize );
    // var Child_options = wp.customize.panel("child_theme_options");
    // Child_options.section.each(function(section){
    //     console.log();
    // })
    // wp.customize.panel.each( function ( panel ) { console.log( panel ) } );
    // wp.customize.section.each( function ( section ) { console.log(section) } );
    var index = 0;
    
    _.each( wp.customize.panel("child_theme_options").sections(), function ( section ) {  
        console.log( section.id );
        
        if( index > 0 ) {
            _.each(  wp.customize.section( section.id ).controls(), function( control ){
               var prefix_block = "#customize-control-home_block_"+index;
            //    console.log( prefix_block );
               
               control.container.find( '.minus_btn' ).on( 'click', function(e) {
                // var main_title = control.container.find( prefix_block+"_item_title" );
                    console.info( 'Minus Button was clicked.' );
                    console.log( $(this).parents('ul') );
                } ); 
                control.container.find( '.plus_btn' ).on( 'click', function(e) {
                    // var main_title = control.container.find( prefix_block+"_item_title" );
                    console.info( 'Plus Button was clicked.' );
                    console.log( $(this).parents('ul') );
                } ); 

            } );
        }
        index++;
        }
    );
 
})