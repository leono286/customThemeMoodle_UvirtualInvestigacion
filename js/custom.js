require(['jquery'], function($) {
    $( document ).ready(function() {

        var actions = {};
        // ********* validateHash ***********
        actions.validateHash = function(hash){
            if ( !(hash.length > 0 && views.hasOwnProperty(hash)) ){
                hash = 'def';
            }
            return hash;
        };

        var views = {
            '#fi': '#formacion_para_inv',
            '#it': '#innovacion_y_trans',
            '#gi': '#gestion_de_inv',
            '#ic': '#inv_cientifica',
            'def': '#initial_div'
        };
        var currenthash = actions.validateHash(window.location.hash);

        //Show the requested view
        var requestedview = views[currenthash];
        $( requestedview ).css('display','block');
        $( '#page-footer' ).css('display','block');

        //Add click listener to nodes and nodesbtn in #initial_div and update de hash location
        $( '#initial_div .node, #initial_div .nodebtn' ).click(function(){
            var elm_id = '#' + $( this ).attr('class').split(" ")[1];
            var keys = Object.keys(views);
            var i = 0;
            while (i < keys.length) {
                var newhash = views[keys[i]] == elm_id ? keys[i] : "";
                if (newhash.length > 0){ break; }
                i++;
            }
            window.location.hash = newhash;
        });

        //Add active class to nodebtn when its corresponding node is hovered
        $( '#initial_div .node' ).hover(
            function(){
                $( '.nodebtn.' + $(this).attr('class').split(" ")[1] ).addClass('focused');
            },
            function(){
                $( '.focused' ).removeClass('focused');
            }
        );

        //Add active class to node when its corresponding nodebtn is hovered
        $( '#initial_div .nodebtn' ).hover(
            function(){
                $( '.node.' + $(this).attr('class').split(" ")[1] ).addClass('focused');
            },
            function(){
                $( '.focused' ).removeClass('focused');
            }
        );

        // Add mouse interaction listeners to action_button buttons to change image on hover
        $( '#formacion_para_inv .action_button .action_button_face' ).mouseover(function() {
            $( this ).find( 'img' ).attr( 'src', $( this ).find( 'img' ).attr( 'src' ) + '_activo' );
        });
        $( '#formacion_para_inv .action_button .action_button_face' ).mouseout(function() {
            $( this ).find( 'img' ).attr( 'src', $( this ).find( 'img' ).attr( 'src' ).replace( '_activo' , ''));
        });

        // Add click listener to action_button_face buttons
        $( '#formacion_para_inv .action_button_face' ).click(function() {
           var parent = $( this ).parent();
            actions.toggleChild(parent, '.action_button_child', 0, true);
        });

        // Add click listener to action_button_child_face buttons
        $( '#formacion_para_inv .action_button_child_face' ).click(function() {
            var parent = $( this ).parent();
            actions.toggleChild(parent, '.action_button_child_content', 150);
        });

        // Add click listener to afiliation button in cientific research
        $( '#inv_cientifica .afiliationBtn a' ).attr({
            "role": "button",
            "data-toggle": "modal"
        });

        $('#afiliationModal form').submit(function(event){
            event.preventDefault();

            if (  $('#afiliationOutcome .outcome').css('display') != 'none' ){
              $('#afiliationOutcome').fadeOut('fast');
              $('#afiliationOutcome .outcome').html('');
            }

            var selectedFaculty = $( this ).find($('#faculty')).find(":selected").text();
            $('#afiliationOutcome .outcome').append('<p>Universidad de Medellín. ' + selectedFaculty + '. Medellín - Colombia.</p>');
              $('#afiliationOutcome').fadeIn('slow');
        });

        $('#afiliationModal #faculty').change(function(){
            $( this ).closest('form').find('button').prop('disabled', false);
        });

        $('#afiliationModal').on('hidden', function () {
            $(this).find($('#afiliationOutcome')).hide();
            $(this).find($('.outcome')).html('');
            $(this).find($('form'))[0].reset();
            $(this).find($('form button')).prop('disabled', true);
        })

        window.onhashchange = function() {
            prevhash = currenthash;
            currenthash = actions.validateHash(window.location.hash);
            actions.changeView(prevhash, currenthash);
        };

        // script Temporal para volver a initial_div desde formacion_para_inv (no definido este comportamiento)
        $('#home_link').click(function(){
            $( '#formacion_para_inv' ).fadeOut('fast',function(){
                $( '#initial_div' ).fadeIn('fast');
                actions.scrollView('#initial_div', 45);
                $( '.action_button_child' ).hide();
                $( '.action_button_child_content' ).hide();

            });
        });

        // ********* changeView ***********
        actions.changeView = function(view2hide, view2show){
            actions.scrollView('nav', 0);
            $( views[view2hide] ).fadeOut('slow',function(){
                $( views[view2show] ).fadeIn('slow');
            });
        };

        // ********* toggleChild ***********
        // This function toggles the child content of a button when pressed, call closeSiblings function
        // to close the child content of siblings and call scrollView function to scroll to the
        // interest content. Expects these arguments:
        // parent - The clicked button parent
        // cls_to_toggle - The class of the child to toggle
        // step - Will be passed to scrollView function
        // sub_children - Will be passed to closeSiblings function
        actions.toggleChild = function (parent, cls_to_toggle, step, sub_children){
            sub_children = false || sub_children;
            actions.closeSiblings( parent , cls_to_toggle , sub_children);
            var opened = $( parent ).find( cls_to_toggle ).css('display') == 'block';
            if (sub_children) {
                $( parent ).find( cls_to_toggle ).slideToggle();
            } else {
                var height = $( parent ).find( cls_to_toggle ).height();
                if (opened){
                    $( parent ).find( cls_to_toggle ).fadeToggle( 'normal', function(){
                        $( parent ).parent().animate({"padding-bottom": "15px"},'normal');
                    } );
                } else {
                    height = $(window).width() > 767 ? height : 0 ;
                    $( parent ).parent().animate({"padding-bottom": (height + 15).toString() + 'px'}, "normal", function(){
                        $( parent ).find( cls_to_toggle ).fadeToggle( 'normal' );
                    });
                }
            }
            if ( !opened ){
                step = $(window).width() > 767 ? step : 50 ;
                actions.scrollView(parent,step);
            }
        };


        // ********* closeSiblings ***********
        // When invoked closeSiblings function closes the child content of siblings

        actions.closeSiblings = function (parent , child_class, sub_children){
            $( parent ).siblings().find( child_class ).fadeOut();
            //Hide the children content just in case any of them are visible
            if (sub_children){
                $( parent ).find( '.action_button_child_content' ).hide(0).closest( '.action_button_child' ).css( "padding-bottom", "15px" );
            }
        };


        // ********* scrollView ***********
        // When invoked scrolls the view to the top of the element of wich id was passed
        // minus the step desired. If step is positive the scroll will be to a position
        // above the element, if negative the position will be below the element.
        actions.scrollView = function (parent, step){
            $("html, body").animate({ scrollTop: $(parent).offset().top - step }, 600);
        };


        // ********* showAfiliationModal ***********
        // Show modal where afiliations are generated
        actions.showAfiliationModal = function(){

        };

    });
});
