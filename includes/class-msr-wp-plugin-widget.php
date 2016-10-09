<?php

use Msr\Service;

class MSR_WP_Widget extends WP_Widget {
    
    /**
     * 
     * @var Msr\Service
     */
    public $msrService;
    
    /**
     * 
     * @var MsrWpLogger
     */
    public $logger;

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        // Instantiate the parent object
        parent::__construct( false, 'MSR Event List' );
        
        $this->msrService = new Service(new Msr\Client());
        $this->logger = MsrWpLogger::instance();
        
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    function widget( $args, $instance ) {
        // Widget output
        
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        
        $orgId = MSR_WP_Plugin_Settings::getOpt(MSR_WP_Plugin_Settings::ORG_ID);
        if (!empty($orgId)) {
            $events = $this->msrService->getOrgCalendar($orgId);
            if (!empty($events->content)) {
                $list = "<ul>\n";
                foreach ($events->content as $event) {
                    $time = time();
                    $regStart = strtotime($event->regStartDate);
                    $regEnd = strtotime($event->regEndDate);
                    $regOpen =  ($regStart <= $time && $regEnd > $time) ? '<span style="color:green;">Open</span>' : '<span style="color:red;">Closed</span>';
                    $list .= "<li><a href=\"".$event->detailUrl."\">".$event->name." - ".date('m/d', strtotime($event->startDate))." $regOpen</a></li>";
                }
                $list .= "</ul>";
                echo $list;
            }else{
                $this->logger->debug("Didn't get any events for org: $orgId");
            }
        }else{
            $this->logger->debug("No org id provided.");
        }
        
        echo $args['after_widget'];
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    function update( $new_instance, $old_instance ) {
        // Save widget options
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        
        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    function form( $instance ) {
        // Output admin widget options form
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
    }
}

function msr_wp_plugin_register_widgets() {
    register_widget( 'MSR_WP_Widget' );
}

add_action( 'widgets_init', 'msr_wp_plugin_register_widgets' );