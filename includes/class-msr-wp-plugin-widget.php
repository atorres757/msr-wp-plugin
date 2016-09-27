<?php

use Msr\Service;

class MSR_WP_Widget extends WP_Widget {
    
    /**
     * 
     * @var Msr\Service
     */
    public $msrService;
    public $msrWpPlugin;

    function __construct() {
        // Instantiate the parent object
        parent::__construct( false, 'MSR Event List' );
        
        $this->msrService = new Service(new Msr\Client());
        $this->msrWpPlugin = MSR_WP_Plugin::instance();
        
    }

    function widget( $args, $instance ) {
        // Widget output
        
        $orgId = get_option(MSR_WP_Plugin_Settings::ORG_ID);
        if (!empty($orgId)) {
            $events = $this->msrService->getOrgCalendar($orgId);
            if (!empty($events->content)) {
                $list = "<ul>\n";
                foreach ($events->content as $event) {
                    $list .= "<li><a href=\"#\">".$event->name."</a></li>";
                }
                $list .= "</ul>";
                echo $list;
            }
        }
    }

    function update( $new_instance, $old_instance ) {
        // Save widget options
    }

    function form( $instance ) {
        // Output admin widget options form
    }
}

function msr_wp_plugin_register_widgets() {
    register_widget( 'MSR_WP_Widget' );
}

add_action( 'widgets_init', 'msr_wp_plugin_register_widgets' );