<?php

/**
 * Suppress "error - 0 - No summary was found for this file" on phpdoc generation
 *
 * @package WPDataAccess\List_Table
 */
namespace WPDataAccess\List_Table;

use WPDataAccess\Connection\WPDADB;
use WPDataAccess\Dashboard\WPDA_Dashboard;
use WPDataAccess\Data_Dictionary\WPDA_Dictionary_Exist;
use WPDataAccess\Data_Dictionary\WPDA_Dictionary_Lists;
use WPDataAccess\Data_Dictionary\WPDA_List_Columns;
use WPDataAccess\Macro\WPDA_Macro;
use WPDataAccess\Plugin_Table_Models\WPDA_CSV_Uploads_Model;
use WPDataAccess\Plugin_Table_Models\WPDA_Media_Model;
use WPDataAccess\Utilities\WPDA_Import;
use WPDataAccess\Utilities\WPDA_Message_Box;
use WPDataAccess\Utilities\WPDA_Repository;
use WPDataAccess\Wordpress_Original;
use WPDataAccess\WPDA;
use WPDataProjects\WPDP;
use WPDataAccess\Plugin_Table_Models\WPDA_Table_Settings_Model;
use WPDataAccess\Plugin_Table_Models\WPDP_Project_Design_Table_Model;
/**
 * Class WPDA_List_Table
 *
 * This class extends WordPress class WP_List_Table. The WordPress WP_List_Table is contained in the package as
 * advised by WordPress and might be updated in future releases.
 *
 * @author  Peter Schulz
 * @since   1.0.0
 */
class WPDA_List_Table extends Wordpress_Original\WP_List_Table {
    /**
     * Base table for list of all tables
     */
    const LIST_BASE_TABLE = 'information_schema.tables';

    /**
     * Default value bulk actions enabled
     */
    const DEFAULT_BULK_ACTIONS_ENABLED = true;

    /**
     * Default value bulk export enabled
     */
    const DEFAULT_BULK_EXPORT_ENABLED = true;

    /**
     * Default value bulk search enabled
     */
    const DEFAULT_SEARCH_BOX_ENABLED = true;

    /**
     * Table row number within the current response
     *
     * @var int
     */
    protected static $list_number = 0;

    /**
     * Menu slug of the current page
     *
     * @var string
     */
    protected $page;

    /**
     * Page title
     *
     * @var string
     */
    protected $title;

    /**
     * Page subtitle
     *
     * @var string
     */
    protected $subtitle = '';

    protected $show_page_title = true;

    /**
     * Database schema name
     *
     * @var string
     */
    protected $schema_name = '';

    /**
     * Database table name
     *
     * @var string
     */
    protected $table_name = '';

    /**
     * Where clause
     *
     * @var string
     */
    protected $where = '';

    /**
     * Order by clause
     *
     * @var string
     */
    protected $orderby = '';

    /**
     * Columns in query
     *
     * @var array
     */
    protected $columns_queried;

    /**
     * Number of rows displayed in list box
     *
     * @var int
     */
    protected $items_per_page;

    /**
     * Page number
     *
     * @var int
     */
    protected $current_page = 1;

    /**
     * Add search box?
     *
     * @var bool
     */
    protected $search_box_enabled = self::DEFAULT_SEARCH_BOX_ENABLED;

    /**
     * Enable bulk actions?
     *
     * @var bool
     */
    protected $bulk_actions_enabled = self::DEFAULT_BULK_ACTIONS_ENABLED;

    /**
     * Enable exports?
     *
     * @var bool
     */
    protected $bulk_export_enabled = self::DEFAULT_BULK_EXPORT_ENABLED;

    /**
     * Show view link?
     *
     * @var string on|off
     */
    protected $show_view_link = null;

    /**
     * Allow inserts?
     *
     * @var string on|off
     */
    protected $allow_insert = null;

    /**
     * Allow updates?
     *
     * @var string on|off
     */
    protected $allow_update = null;

    /**
     * Allow deletes?
     *
     * @var string on|off
     */
    protected $allow_delete = null;

    /**
     * Hides tablenav
     *
     * @var bool
     */
    protected $hide_navigation = false;

    /**
     * Reference to column list
     *
     * @var WPDA_List_Columns
     */
    protected $wpda_list_columns;

    /**
     * Reference to dictionary object
     *
     * @var WPDA_Dictionary_Exist
     */
    protected $wpda_data_dictionary;

    /**
     * Column headers (labels)
     *
     * @var array
     */
    protected $column_headers;

    /**
     * Reference to import object
     *
     * @var WPDA_Import
     */
    protected $wpda_import = null;

    /**
     * Child tab clicked (used for parent child relationships only)
     *
     * @var null
     */
    protected $child_tab = '';

    /**
     * Search string (entered by user or taken from cookie)
     *
     * @var null|string
     */
    protected $search_value = null;

    /**
     * Previous search string
     *
     * @var null|string
     */
    protected $search_value_old = null;

    /**
     * Page number item name (default 'page_number')
     *
     * The name can be changed for pages on multiple levels. This is needed to get back to the right page in
     * parent-child page.
     *
     * @var string
     */
    protected $page_number_item_name = 'page_number';

    /**
     * Real page number
     *
     * @var null
     */
    protected $page_number_link = '';

    /**
     * Page number text item
     *
     * @var null
     */
    protected $page_number_item = '';

    /**
     * Make the default accessible to other classes
     */
    const SEARCH_ITEM_NAME_DEFAULT = 'wpda_s';

    /**
     * Name of search item (WP default 's')
     *
     * @var string
     */
    protected $search_item_name = self::SEARCH_ITEM_NAME_DEFAULT;

    /**
     * Name of the column containing action links
     *
     * Default is the first column displayed
     *
     * @var string
     */
    protected $first_display_column = '';

    /**
     * Table settings
     *
     * @var null|object
     */
    protected $wpda_table_settings = null;

    /**
     * Project table settings
     *
     * @var null|object
     */
    protected $wpda_project_table_settings = null;

    /**
     * Show help icon if help url is available
     *
     * @var null|string
     */
    protected $help_url = null;

    /**
     * Store columns in array with column name as index for fast access
     *
     * @var array
     */
    protected $columns_indexed = array();

    /**
     * Variables used to store table estimate row count data
     *
     * @var string
     */
    protected $table_engine = '';

    /**
     * Table rows
     *
     * @var mixed|string
     */
    protected $table_rows = '';

    /**
     * Estimated row count
     *
     * @var array|int
     */
    protected $row_count_estimate = array();

    /**
     * Project page id
     *
     * Helper to hide schema and table name in export links on web pages
     *
     * @var null
     */
    protected $pid = null;

    /**
     * Cache columns
     *
     * @var null
     */
    protected $wpda_cached_columns = null;

    /**
     * WPDA_List_Table constructor
     *
     * A table name must be provided in the constructor call. The table must be a valid MySQL database table to
     * which access (to the back-end) is granted. If no table name is provided, the table does not exist or access
     * to the back-end for the given table is not granted, processing is stopped. It makes no sense to continue
     * without a valid table. A check for table existence is performed to prevent SQL injection.
     *
     * There are two types of tables to build a list table on:
     * + List of tables in the WordPress database schema
     * + List of rows in a specific table
     *
     * To build a list of tables in the WordPress database schema, we query table 'information_schema.tables'
     * (which is in fact a view). This is the only query allowed outside the WordPress database schema. The
     * table/view name is stored in constant WPDA_List_Table::LIST_BASE_TABLE for validation purposes.
     *
     * A list of rows for a specific table is based on WordPress class WP_List_Table.
     *
     * WPDA_List_Table can be used to build list tables for views as well. View based list tables however, do not
     * support insert, update, delete, import and export actions.
     *
     * A table name is not the only thing we need to build a list table. We also need to have access to the
     * table columns. If no table columns are provided execution is stopped as well.
     *
     * @param array $args [
     *
     * 'table_name'              => (string) Database table name
     *
     * 'wpda_list_columns'       => (object) Reference to a WPDA_List_Columns object
     *
     * 'singular'                => (string) Singular object label
     *
     * 'plural'                  => (string) plural object label
     *
     * 'ajax'                    => (string) TRUE = list table support Ajax
     *
     * 'column_headers'          => (array|string) Column headers
     *
     * 'title'                   => (string) Page title
     *
     * 'subtitle'                => (string) Page subtitle
     *
     * 'bulk_export_enabled'     => (boolean)
     *
     * 'search_box_enabled'      => (boolean)
     *
     * 'bulk_actions_enabled'    => (boolean)
     *
     * 'show_view_link'          => (string) on|off
     *
     * 'allow_insert'            => (string) on|off
     *
     * 'allow_update'            => (string) on|off
     *
     * 'allow_delete'            => (string) on|off
     *
     * 'allow_import'            => (string) on|off
     *
     * 'hide_navigation'         => (boolean)
     *
     * 'default_where'           => (string)
     *
     * ]
     * @since   1.0.0
     */
    public function __construct( $args = array() ) {
        global $wpdb;
        if ( !isset( $args['table_name'] ) ) {
            // Calling WPDA_List_Table without a table_name doesn't make sense.
            wp_die( __( 'ERROR: Wrong arguments [no table argument]', 'wp-data-access' ) );
        }
        if ( !isset( $args['wpda_list_columns'] ) ) {
            // Calling WPDA_List_Table without a column list is not allowed.
            wp_die( __( 'ERROR: Wrong arguments [no columns argument]', 'wp-data-access' ) );
        }
        parent::__construct( array(
            'singular' => ( isset( $args['singular'] ) ? $args['singular'] : __( 'Row', 'wp-data-access' ) ),
            'plural'   => ( isset( $args['plural'] ) ? $args['plural'] : __( 'Rows', 'wp-data-access' ) ),
            'ajax'     => ( isset( $args['ajax'] ) ? $args['ajax'] : false ),
        ) );
        // Set schema name is available.
        if ( isset( $args['wpdaschema_name'] ) ) {
            $this->schema_name = $args['wpdaschema_name'];
        }
        // Set table name (availability already checked).
        $this->table_name = $args['table_name'];
        if ( self::LIST_BASE_TABLE !== $this->table_name ) {
            // Whenever a table name is provided through a URL we are risking an SQL injection attack. Our
            // defence mechanism here is to check whether the table name provided exists in our database.
            // If it does not we'll terminate the process with an error.
            // Although this check is only needed when a table name is provided through the URL we will perform
            // it in all situations. It is a fast query which makes our application much more safe and reliable.
            $this->wpda_data_dictionary = new WPDA_Dictionary_Exist($this->schema_name, $this->table_name);
            if ( !$this->wpda_data_dictionary->table_exists() ) {
                wp_die( __( 'ERROR: Invalid table name or not authorized', 'wp-data-access' ) );
            }
        }
        $this->pid = ( isset( $args['pid'] ) ? $args['pid'] : '' );
        // Get menu slag of current page.
        if ( isset( $_REQUEST['page'] ) ) {
            $this->page = sanitize_text_field( wp_unslash( $_REQUEST['page'] ) );
            // input var okay.
        } else {
            // In order to show a list table we need a page.
            wp_die( __( 'ERROR: Wrong arguments [no page argument]', 'wp-data-access' ) );
        }
        // Use column list: argument wpda_list_columns (availability already checked).
        $this->wpda_list_columns =& $args['wpda_list_columns'];
        // Set pagination.
        if ( is_admin() ) {
            $this->items_per_page = WPDA::get_option( WPDA::OPTION_BE_PAGINATION );
        } else {
            $this->items_per_page = WPDA::get_option( WPDA::OPTION_FE_PAGINATION );
        }
        // Overwrite column header text if column headers were provided.
        $this->column_headers = ( isset( $args['column_headers'] ) ? $args['column_headers'] : '' );
        // Set title.
        if ( isset( $args['title'] ) ) {
            $this->title = $args['title'];
        } else {
            $this->title = __( 'Table', 'wp-data-access' ) . ' ' . strtoupper( $this->table_name );
        }
        // Set subtitle.
        if ( isset( $args['subtitle'] ) ) {
            $this->subtitle = $args['subtitle'];
        } else {
            $wp_tables = $wpdb->tables( 'all', true );
            if ( isset( $wp_tables[substr( $this->table_name, strlen( $wpdb->prefix ) )] ) ) {
                $this->subtitle = '<span class="dashicons dashicons-warning"></span> ' . WPDA::get_table_type_text( WPDA::TABLE_TYPE_WP );
            } elseif ( WPDA::is_wpda_table( $this->table_name ) ) {
                $this->subtitle = '<span class="dashicons dashicons-warning"></span> ' . WPDA::get_table_type_text( WPDA::TABLE_TYPE_WPDA );
            }
        }
        if ( !(isset( $args['allow_import'] ) && 'off' === $args['allow_import']) ) {
            try {
                // Instantiate WPDA_Import.
                $this->wpda_import = new WPDA_Import(( is_admin() ? "?page={$this->page}" : '' ), $this->schema_name, $this->table_name);
            } catch ( \Exception $e ) {
                // If import is turned off instantiation will fail. Handle is set to null (check in future calls).
                $this->wpda_import = null;
            }
        }
        if ( isset( $args['bulk_export_enabled'] ) ) {
            $this->bulk_export_enabled = $args['bulk_export_enabled'];
        }
        if ( isset( $args['search_box_enabled'] ) ) {
            $this->search_box_enabled = $args['search_box_enabled'];
        }
        if ( isset( $args['bulk_actions_enabled'] ) ) {
            $this->bulk_actions_enabled = $args['bulk_actions_enabled'];
        }
        if ( 'on' !== WPDA::get_option( WPDA::OPTION_BE_VIEW_LINK ) ) {
            $this->show_view_link = WPDA::get_option( WPDA::OPTION_BE_VIEW_LINK );
        } else {
            if ( isset( $args['show_view_link'] ) ) {
                $this->show_view_link = $args['show_view_link'];
            } else {
                $this->show_view_link = WPDA::get_option( WPDA::OPTION_BE_VIEW_LINK );
            }
        }
        if ( 'on' !== WPDA::get_option( WPDA::OPTION_BE_ALLOW_INSERT ) ) {
            $this->allow_insert = WPDA::get_option( WPDA::OPTION_BE_ALLOW_INSERT );
        } else {
            if ( isset( $args['allow_insert'] ) ) {
                $this->allow_insert = $args['allow_insert'];
            } else {
                $this->allow_insert = WPDA::get_option( WPDA::OPTION_BE_ALLOW_INSERT );
            }
        }
        if ( 'on' !== WPDA::get_option( WPDA::OPTION_BE_ALLOW_UPDATE ) ) {
            $this->allow_update = WPDA::get_option( WPDA::OPTION_BE_ALLOW_UPDATE );
        } else {
            if ( isset( $args['allow_update'] ) ) {
                $this->allow_update = $args['allow_update'];
            } else {
                $this->allow_update = WPDA::get_option( WPDA::OPTION_BE_ALLOW_UPDATE );
            }
        }
        if ( 'on' !== WPDA::get_option( WPDA::OPTION_BE_ALLOW_DELETE ) ) {
            $this->allow_delete = WPDA::get_option( WPDA::OPTION_BE_ALLOW_DELETE );
        } else {
            if ( isset( $args['allow_delete'] ) ) {
                $this->allow_delete = $args['allow_delete'];
            } else {
                $this->allow_delete = WPDA::get_option( WPDA::OPTION_BE_ALLOW_DELETE );
            }
        }
        if ( isset( $args['hide_navigation'] ) ) {
            $this->hide_navigation = $args['hide_navigation'];
        }
        $this->search_value = ( is_scalar( $this->get_search_value() ) ? str_replace( "\\'", '', (string) $this->get_search_value() ) : '' );
        if ( isset( $_REQUEST["{$this->search_item_name}_old_value"] ) ) {
            $this->search_value_old = sanitize_text_field( wp_unslash( $_REQUEST["{$this->search_item_name}_old_value"] ) );
            // input var okay.
        } else {
            $this->search_value_old = $this->search_value;
        }
        // Get page number(s).
        if ( 'page_number' !== $this->page_number_item_name ) {
            if ( isset( $_REQUEST['page_number'] ) ) {
                $requested_page_number = sanitize_text_field( wp_unslash( $_REQUEST['page_number'] ) );
                // input var okay.
                $this->page_number_link = '&page_number=' . $requested_page_number;
                $this->page_number_item = "<input type='hidden' name='page_number' value='" . $requested_page_number . "' />";
            }
        }
        $this->page_number_link .= '&paged=' . $this->get_pagenum();
        $this->page_number_item .= "<input type='hidden' name='" . $this->page_number_item_name . "' value='" . $this->get_pagenum() . "' />";
        // Add search arguments to link to return to same page.
        foreach ( $_REQUEST as $key => $value ) {
            if ( substr( $key, 0, 19 ) === 'wpda_search_column_' ) {
                if ( is_array( $value ) ) {
                    foreach ( $value as $elem_key => $elem_value ) {
                        $this->page_number_link .= "&{$elem_key}={$elem_value}";
                        $this->page_number_item .= "<input type='hidden' name='{$key}[]' value='{$elem_value}' />";
                    }
                } else {
                    $this->page_number_link .= "&{$key}={$value}";
                    $this->page_number_item .= "<input type='hidden' name='{$key}' value='{$value}' />";
                }
            }
        }
        // Check if a WHERE clause (filter) was defined.
        if ( isset( $args['default_where'] ) ) {
            $this->where = $args['default_where'];
        }
        // Get table settings.
        $wpda_table_settings = WPDA_Table_Settings_Model::query( $this->table_name, $this->schema_name );
        if ( isset( $wpda_table_settings[0]['wpda_table_settings'] ) ) {
            $this->wpda_table_settings = json_decode( $wpda_table_settings[0]['wpda_table_settings'] );
        }
        // Get estimated row count.
        $this->row_count_estimate = WPDA::get_row_count_estimate( $this->schema_name, $this->table_name, $this->wpda_table_settings );
        $this->table_rows = $this->row_count_estimate['row_count'];
        // Get project table settings.
        global $wpda_project_mode;
        if ( is_array( $wpda_project_mode ) ) {
            $setname = $wpda_project_mode['setname'];
            $wpda_project_table_settings = null;
            $wpda_project_table_settings_db = WPDP_Project_Design_Table_Model::static_query( $this->schema_name, $this->table_name, $setname );
            if ( isset( $wpda_project_table_settings_db->tableinfo ) ) {
                $this->wpda_project_table_settings = $wpda_project_table_settings_db->tableinfo;
            }
        }
        if ( isset( $args['show_page_title'] ) && false === $args['show_page_title'] ) {
            $this->show_page_title = $args['show_page_title'];
        }
        if ( isset( $args['help_url'] ) ) {
            $this->help_url = $args['help_url'];
        }
        foreach ( $this->wpda_list_columns->get_table_columns() as $table_columns ) {
            $this->columns_indexed[$table_columns['column_name']] = $table_columns;
        }
    }

    /**
     * Overwrite method
     *
     * @return int|void
     */
    public function get_pagenum() {
        if ( isset( $_REQUEST[$this->page_number_item_name] ) ) {
            $pagenum = ( isset( $_REQUEST[$this->page_number_item_name] ) ? absint( $_REQUEST[$this->page_number_item_name] ) : 0 );
            if ( isset( $this->_pagination_args['total_pages'] ) && $pagenum > $this->_pagination_args['total_pages'] ) {
                $pagenum = $this->_pagination_args['total_pages'];
            }
            return max( 1, $pagenum );
        } else {
            return parent::get_pagenum();
        }
    }

    /**
     * Set columns to be queries
     *
     * Set columns to be queried and shown in the list table.
     * By default all columns in the table will be displayed.
     *
     * @param mixed $columns_queried Column list.
     *
     * @since   1.0.0
     */
    public function set_columns_queried( $columns_queried ) {
        $this->columns_queried = $columns_queried;
    }

    /**
     * Enable or disable bulk actions
     *
     * @param boolean $bulk_actions_enabled TRUE = allowed, FALSE = not allowed.
     *
     * @since   1.0.0
     */
    public function set_bulk_actions_enabled( $bulk_actions_enabled ) {
        $this->bulk_actions_enabled = $bulk_actions_enabled;
    }

    /**
     * Enable or disable bulk export options
     *
     * @param boolean $bulk_export_enabled TRUE = allowed, FALSE = not allowed.
     *
     * @since   1.0.0
     */
    public function set_bulk_export_enabled( $bulk_export_enabled ) {
        $this->bulk_export_enabled = $bulk_export_enabled;
    }

    /**
     * Show or hide search box
     *
     * @param boolean $search_box_enabled TRUE = show search box, FALSE = do not show search bow.
     *
     * @since   1.0.0
     */
    public function set_search_box_enabled( $search_box_enabled ) {
        $this->search_box_enabled = $search_box_enabled;
    }

    /**
     * Set page title
     *
     * @param string $title Page title.
     *
     * @since   1.0.0
     */
    public function set_title( $title ) {
        $this->title = $title;
    }

    /**
     * Set page subtitle
     *
     * @param string $subtitle Page subtitle.
     *
     * @since   1.0.0
     */
    public function set_subtitle( $subtitle ) {
        $this->subtitle = $subtitle;
    }

    /**
     * I18n text displayed when no data found
     *
     * @since   1.0.0
     */
    public function no_items() {
        echo __( 'No data found', 'wp-data-access' );
    }

    /**
     * Use this method to build parent child relationships.
     *
     * Overwrite this function if you want to use the list table as a child list table related to some parent
     * form. You can add parent arguments to calls to make sure you get back to the right parent.
     *
     * @param array $item Column info.
     * @return string String contains parent arguments.
     * @since   1.5.0
     */
    protected function add_parent_args_as_string( $item ) {
        return '';
    }

    /**
     * Render columns
     *
     * Three links are provided for every list table row:
     * + 'View' => Link to view form (readonly data entry form)
     * + 'Edit' => Link to data entry form (updatable)
     * + 'Delete' => Link to delete record from database table
     *
     * Links to view, edit and delete records are only available if a primary key for the table is found. Without
     * a primary key unique identification of records is not possible.
     *
     * Links to action are offered through hidden forms to prevent long URL's and problem when refreshing pages
     * manually. More information about how and why is provided in source code at place where I thought the
     * information could be helpful.
     *
     * @param array  $item Column info.
     * @param string $column_name Column name.
     *
     * @return mixed Value display in list table column
     * @since   1.0.0
     */
    public function column_default( $item, $column_name ) {
        if ( $this->wpda_list_columns->get_table_columns()[0]['column_name'] === $column_name || $column_name === $this->first_display_column ) {
            // First column: add row actions.
            $count = count( $this->wpda_list_columns->get_table_primary_key() );
            //phpcs:ignore - 8.1 proof
            if ( 0 === $count ) {
                // No actions without a primary key!
                // This automatically covers view processing correctly.
                return $this->render_column_content( $item, $column_name ) . $this->row_actions( array(
                    'wpda_hide_column' => '',
                ) );
            } else {
                // Check rights.
                if ( 'off' === $this->show_view_link && 'off' === $this->allow_update && 'off' === $this->allow_delete ) {
                    // No rights!
                    $actions = array();
                    $this->column_default_add_action( $item, $column_name, $actions );
                    if ( is_array( $actions ) && count( $actions ) > 0 ) {
                        //phpcs:ignore - 8.1 proof
                        return sprintf( '%1$s %2$s', $this->render_column_content( $item, $column_name ), $this->row_actions( $actions ) );
                    } else {
                        return sprintf( '%1$s', $this->render_column_content( $item, $column_name ) );
                    }
                }
                // Check if row security is enabled.
                $row_security = isset( $this->wpda_table_settings->table_settings->row_level_security ) && 'true' === $this->wpda_table_settings->table_settings->row_level_security;
                // To prevent our URLs containing many arguments, we'll use post to submit row actions. Since our
                // list table is build within a form and we cannot use nested forms we'll use a container (id =
                // wpda_invisible_container) defined outside the list table, and add our forms to that container.
                // We'll use jQuery to add our forms to the container. From the links in our rows we can then just
                // submit any form in that container with jQuery as well.
                $form_id = '_' . self::$list_number++;
                $wp_nonce_keys = '';
                $row_security_keys = '';
                // We need to add keys and values for multi-column primary keys.
                foreach ( $this->wpda_list_columns->get_table_primary_key() as $key ) {
                    $wp_nonce_keys .= "-{$item[$key]}";
                    if ( $row_security ) {
                        $row_security_keys .= "-{$key}-{$item[$key]}";
                    }
                }
                if ( $row_security ) {
                    $row_security_nonce = wp_create_nonce( "wpda-row-level-security-{$this->table_name}{$row_security_keys}" );
                    $row_security_nonce_field = "<input type='hidden' name='rownonce' value='" . esc_attr( $row_security_nonce ) . "' />";
                } else {
                    $row_security_nonce_field = '';
                }
                // Prepare url.
                if ( is_admin() ) {
                    $url = "?page={$this->page}";
                } else {
                    $url = '';
                }
                if ( 'on' === $this->show_view_link ) {
                    $wp_nonce_action = "wpda-query-{$this->table_name}{$wp_nonce_keys}";
                    $wp_nonce = wp_create_nonce( $wp_nonce_action );
                    // Build the row action. Use jQuery to add form to container.
                    // All items escaped in create_post_form().
                    $view_form = $this->create_post_form(
                        $item,
                        "view_form{$form_id}",
                        'view',
                        $url,
                        $wp_nonce,
                        $row_security_nonce_field,
                        $this->schema_name,
                        $this->table_name
                    );
                    ?>

						<script type='text/javascript'>
							jQuery("#wpda_invisible_container").append("<?php 
                    echo $view_form;
                    // phpcs:ignore WordPress.Security.EscapeOutput
                    ?>");
						</script>

						<?php 
                    // Add link to submit form.
                    $actions['view'] = sprintf(
                        '<a href="javascript:void(0)"
                                    class="edit wpda_tooltip"
                                    title="%s"
                                    onclick="jQuery(\'#%s\').submit()">
                                    <span style="white-space: nowrap">
										<i class="fas fa-eye wpda_icon_on_button"></i>
										%s
                                    </span>
                                </a>
                                ',
                        __( 'View row data', 'wp-data-access' ),
                        "view_form{$form_id}",
                        __( 'View', 'wp-data-access' )
                    );
                }
                if ( 'on' === $this->allow_update || WPDA::is_wpda_table( $this->table_name ) ) {
                    $wp_nonce_action = "wpda-query-{$this->table_name}{$wp_nonce_keys}";
                    $wp_nonce = wp_create_nonce( $wp_nonce_action );
                    // Build the row action. Use jQuery to add form to container.
                    // All items escaped in create_post_form().
                    $edit_form = $this->create_post_form(
                        $item,
                        "edit_form{$form_id}",
                        'edit',
                        $url,
                        $wp_nonce,
                        $row_security_nonce_field,
                        $this->schema_name,
                        $this->table_name
                    );
                    ?>

						<script type='text/javascript'>
							jQuery("#wpda_invisible_container").append("<?php 
                    echo $edit_form;
                    // phpcs:ignore WordPress.Security.EscapeOutput
                    ?>");
						</script>

						<?php 
                    // Add link to submit form.
                    $actions['edit'] = sprintf(
                        '<a href="javascript:void(0)"
                                    class="edit wpda_tooltip"
                                    title="%s"
                                    onclick="jQuery(\'#%s\').submit()">
                                    <span style="white-space: nowrap">
										<i class="fas fa-pen wpda_icon_on_button"></i>
										%s
                                    </span>
                                </a>
                                ',
                        __( 'Edit row data', 'wp-data-access' ),
                        "edit_form{$form_id}",
                        __( 'Edit', 'wp-data-access' )
                    );
                }
                if ( 'on' === $this->allow_delete || WPDA::is_wpda_table( $this->table_name ) ) {
                    $wp_nonce_action = "wpda-delete-{$this->table_name}{$wp_nonce_keys}";
                    $wp_nonce = wp_create_nonce( $wp_nonce_action );
                    // Build the row action. Use jQuery to add form to container.
                    // All items escaped in create_post_form().
                    $delete_form = $this->create_post_form(
                        $item,
                        "delete_form{$form_id}",
                        'delete',
                        $url,
                        $wp_nonce,
                        $row_security_nonce_field,
                        $this->schema_name,
                        $this->table_name
                    );
                    ?>

						<script type='text/javascript'>
							jQuery("#wpda_invisible_container").append("<?php 
                    echo $delete_form;
                    // phpcs:ignore WordPress.Security.EscapeOutput
                    ?>");
						</script>

						<?php 
                    // Add link to submit form.
                    $warning = __( "You are about to permanently delete these items from your site.\\nThis action cannot be undone.\\n\\'Cancel\\' to stop, \\'OK\\' to delete.", 'wp-data-access' );
                    $actions['delete'] = sprintf(
                        '<a href="javascript:void(0)"
                                    class="delete wpda_tooltip"
                                    title="%s"
                                    onclick="if (confirm(\'%s\')) jQuery(\'#%s\').submit()">
                                    <span style="white-space: nowrap">
										<i class="fas fa-trash wpda_icon_on_button"></i>
										%s
                                    </span>
                                </a>
                                ',
                        __( 'Delete row data (this cannot be undone)', 'wp-data-access' ),
                        $warning,
                        "delete_form{$form_id}",
                        __( 'Delete', 'wp-data-access' )
                    );
                }
                // Developers can add actions by adding their own implementation of following method.
                $this->column_default_add_action( $item, $column_name, $actions );
                if ( has_filter( 'wpda_column_default' ) ) {
                    // Use filter.
                    $filter = apply_filters(
                        'wpda_column_default',
                        '',
                        $item,
                        $column_name,
                        $this->table_name,
                        $this->schema_name,
                        $this->wpda_list_columns,
                        self::$list_number,
                        $this
                    );
                    if ( null !== $filter ) {
                        return sprintf( '%1$s %2$s', $filter, $this->row_actions( $actions ) );
                    }
                }
                return sprintf( '%1$s %2$s', $this->render_column_content( $item, $column_name ), $this->row_actions( $actions ) );
            }
        } else {
            if ( substr( $column_name, 0, 15 ) === 'wpda_hyperlink_' ) {
                $hyperlink_no = substr( $column_name, 15 );
                if ( isset( $this->wpda_table_settings->hyperlinks[$hyperlink_no] ) ) {
                    $hyperlink = $this->wpda_table_settings->hyperlinks[$hyperlink_no];
                    $hyperlink_html = ( isset( $hyperlink->hyperlink_html ) ? $hyperlink->hyperlink_html : '' );
                    if ( '' !== $hyperlink_html ) {
                        // Substitute values.
                        foreach ( $item as $key => $value ) {
                            $hyperlink_html = str_replace( "\$\${$key}\$\$", str_replace( ' ', '%20', (string) $value ), $hyperlink_html );
                        }
                    }
                    $macro = new WPDA_Macro($hyperlink_html);
                    $hyperlink_html = $macro->exe_macro();
                    if ( '' !== $hyperlink_html ) {
                        // Link is not empty AFTER substitution.
                        if ( false !== strpos( ltrim( $hyperlink_html ), '&lt;' ) ) {
                            return html_entity_decode( $hyperlink_html );
                        } else {
                            $hyperlink_label = ( isset( $hyperlink->hyperlink_label ) ? $hyperlink->hyperlink_label : '' );
                            $hyperlink_target = ( isset( $hyperlink->hyperlink_target ) ? $hyperlink->hyperlink_target : false );
                            $target = ( true === $hyperlink_target ? "target='_blank'" : '' );
                            return "<a href='" . str_replace( ' ', '+', trim( $hyperlink_html ) ) . "' {$target}>{$hyperlink_label}</a>";
                        }
                    } else {
                        return '';
                    }
                }
                return 'ERROR';
            } else {
                // Check if column is of type media.
                $media_type = WPDA_Media_Model::get_column_media( $this->table_name, $column_name, $this->schema_name );
                if ( 'Image' === $media_type ) {
                    $image_ids = explode( ',', (string) $item[$column_name] );
                    //phpcs:ignore - 8.1 proof
                    $image_src = '';
                    foreach ( $image_ids as $image_id ) {
                        $url = wp_get_attachment_url( esc_attr( $image_id ) );
                        if ( false !== $url ) {
                            $title = get_the_title( esc_attr( $image_id ) );
                            $image_src .= ( '' !== $image_src ? '<br/>' : '' );
                            $image_src .= sprintf( '<img src="%s" class="wpda_tooltip" title="%s" width="100%%">', $url, $title );
                        }
                    }
                    return $image_src;
                } elseif ( 'ImageURL' === $media_type ) {
                    return sprintf( '<img src="%s" class="wpda_tooltip" width="100%%">', $item[$column_name] );
                } elseif ( 'Attachment' === $media_type ) {
                    $media_ids = explode( ',', (string) $item[$column_name] );
                    //phpcs:ignore - 8.1 proof
                    $media_links = '';
                    foreach ( $media_ids as $media_id ) {
                        $url = wp_get_attachment_url( esc_attr( $media_id ) );
                        if ( false !== $url ) {
                            $mime_type = get_post_mime_type( $media_id );
                            if ( false !== $mime_type ) {
                                $title = get_the_title( esc_attr( $media_id ) );
                                $media_links .= self::column_media_attachment( $url, $title, $mime_type );
                            }
                        }
                    }
                    return $media_links;
                } elseif ( 'Hyperlink' === $media_type ) {
                    if ( null === $item[$column_name] || '' === $item[$column_name] ) {
                        return '';
                    } else {
                        if ( !(isset( $this->wpda_table_settings->table_settings->hyperlink_definition ) && 'text' === $this->wpda_table_settings->table_settings->hyperlink_definition) ) {
                            $hyperlink = json_decode( $item[$column_name], true );
                            if ( is_array( $hyperlink ) && isset( $hyperlink['label'] ) && isset( $hyperlink['url'] ) && isset( $hyperlink['target'] ) ) {
                                if ( '' === $hyperlink['url'] ) {
                                    return '';
                                } else {
                                    return "<a href='{$hyperlink['url']}' target='{$hyperlink['target']}'>{$hyperlink['label']}</a>";
                                }
                            } else {
                                return '';
                            }
                        } else {
                            $hyperlink_label = $this->wpda_list_columns->get_column_label( $column_name );
                            return "<a href='{$item[$column_name]}' target='_blank'>{$hyperlink_label}</a>";
                        }
                    }
                } elseif ( 'Audio' === $media_type ) {
                    $audio_ids = explode( ',', (string) $item[$column_name] );
                    //phpcs:ignore - 8.1 proof
                    $audio_src = '';
                    foreach ( $audio_ids as $audio_id ) {
                        if ( 'audio' === substr( get_post_mime_type( $audio_id ), 0, 5 ) ) {
                            $url = wp_get_attachment_url( esc_attr( $audio_id ) );
                            if ( false !== $url ) {
                                $title = get_the_title( esc_attr( $audio_id ) );
                                if ( false !== $url ) {
                                    $audio_src .= '<div title="' . $title . '" class="wpda_tooltip">' . do_shortcode( '[audio src="' . $url . '"]' ) . '</div>';
                                }
                            }
                        }
                    }
                    return $audio_src;
                } elseif ( 'Video' === $media_type ) {
                    $video_ids = explode( ',', (string) $item[$column_name] );
                    //phpcs:ignore - 8.1 proof
                    $video_src = '';
                    foreach ( $video_ids as $video_id ) {
                        if ( 'video' === substr( get_post_mime_type( $video_id ), 0, 5 ) ) {
                            $url = wp_get_attachment_url( esc_attr( $video_id ) );
                            if ( false !== $url ) {
                                if ( false !== $url ) {
                                    $video_src .= do_shortcode( '[video src="' . $url . '"]' );
                                }
                            }
                        }
                    }
                    return $video_src;
                }
            }
            if ( has_filter( 'wpda_column_default' ) ) {
                // Use filter.
                $filter = apply_filters(
                    'wpda_column_default',
                    '',
                    $item,
                    $column_name,
                    $this->table_name,
                    $this->schema_name,
                    $this->wpda_list_columns,
                    self::$list_number,
                    $this
                );
                if ( null !== $filter ) {
                    return $filter;
                }
            }
            if ( 'csv' !== WPDA::get_option( WPDA::OPTION_PLUGIN_SET_FORMAT ) && isset( $this->columns_indexed[$column_name]['data_type'] ) && 'set' === $this->columns_indexed[$column_name]['data_type'] ) {
                $list = '<' . WPDA::get_option( WPDA::OPTION_PLUGIN_SET_FORMAT ) . '>';
                $listarray = explode( ',', (string) $item[$column_name] );
                //phpcs:ignore - 8.1 proof
                foreach ( $listarray as $listitem ) {
                    $list .= "<li>{$listitem}</li>";
                }
                $list .= '</' . WPDA::get_option( WPDA::OPTION_PLUGIN_SET_FORMAT ) . '>';
                return $list;
            }
            return $this->render_column_content( $item, $column_name );
        }
    }

    /**
     * Create post form which is added to the invisible container
     *
     * @param array  $item Column info.
     * @param string $form_id Form ID.
     * @param string $action Form action.
     * @param string $url URL admin page.
     * @param string $wp_nonce Nonce.
     * @param string $row_security_nonce_field Nonce for row level access security.
     * @param string $schema_name Database schema name.
     * @param string $table_name Database table name.
     *
     * @return array|string|string[]
     */
    private function create_post_form(
        $item,
        $form_id,
        $action,
        $url,
        $wp_nonce,
        $row_security_nonce_field,
        $schema_name,
        $table_name
    ) {
        // Already escaped: $url, $row_security_nonce_field, get_key_input_fields(), add_parent_args_as_string().
        $esc_attr = 'esc_attr';
        $get_key_input_fields = $this->get_key_input_fields( $item );
        $add_parent_args_as_string = $this->add_parent_args_as_string( $item );
        $page_number_item = $this->page_number_item;
        $case_sensitive_search = ( isset( $_REQUEST['wpda_c'] ) && 'true' === $_REQUEST['wpda_c'] ? "<input type='hidden' name='wpda_c' value='true'>" : '' );
        $add_schema_and_table_name = ( !is_admin() ? '' : "\n\t\t\t\t\t<input type='hidden' name='wpdaschema_name' value='{$esc_attr( $schema_name )}' />\n\t\t\t\t\t<input type='hidden' name='table_name' value='{$esc_attr( $table_name )}' />\n\t\t\t\t" );
        // Hide schema and table name on front-end
        $form = <<<EOT
\t\t\t\t<form id='{$esc_attr( $form_id )}' action='{$url}' method='post'>
\t\t\t\t\t{$get_key_input_fields}
\t\t\t\t\t{$add_parent_args_as_string}
\t\t\t\t\t{$add_schema_and_table_name}
\t\t\t\t\t<input type='hidden' name='action' value='{$esc_attr( $action )}' />
\t\t\t\t\t<input type='hidden' name='_wpnonce' value='{$esc_attr( $wp_nonce )}'>
\t\t\t\t\t{$row_security_nonce_field}
\t\t\t\t\t{$page_number_item}
\t\t\t\t\t{$case_sensitive_search}
\t\t\t\t</form>
EOT;
        return str_replace( array("\n", "\r"), '', $form );
    }

    /**
     * Create media link
     *
     * @param string $url Media URL.
     * @param string $title Media title.
     * @param string $mime_type Mime type.
     *
     * @return string
     */
    public static function column_media_attachment( $url, $title, $mime_type ) {
        if ( 'image' === substr( $mime_type, 0, 5 ) ) {
            $class = 'dashicons-format-image';
        } elseif ( 'audio' === substr( $mime_type, 0, 5 ) ) {
            $class = 'dashicons-playlist-audio';
        } elseif ( 'video' === substr( $mime_type, 0, 5 ) ) {
            $class = 'dashicons-playlist-video';
        } elseif ( 'application' === substr( $mime_type, 0, 11 ) ) {
            $class = 'dashicons-media-document';
        } else {
            $class = 'dashicons-external';
        }
        return sprintf(
            '<a href="%s" title="%s" target="_blank"><span class="dashicons %s wpda_attachment_icon"></span></a>',
            $url,
            $title,
            $class
        );
    }

    /**
     * Overwrite method to prevent double row actions
     *
     * @param object $item Table column.
     * @param string $column_name Column name.
     * @param string $primary Primary key.
     *
     * @return string
     */
    protected function handle_row_actions( $item, $column_name, $primary ) {
        return '';
    }

    /**
     * Render column content
     *
     * Strip content if too long and replace & character.
     *
     * @param object $item Table column.
     * @param string $column_name Database column name.
     *
     * @return string Rendered column content
     */
    protected function render_column_content( $item, $column_name, $substitute_newlines = true ) {
        $column_content = ( isset( $item["lookup_value_{$column_name}"] ) ? $item["lookup_value_{$column_name}"] : $item[$column_name] );
        if ( 'off' === WPDA::get_option( WPDA::OPTION_BE_TEXT_WRAP_SWITCH ) && WPDA::get_option( WPDA::OPTION_BE_TEXT_WRAP ) < strlen( (string) $column_content ) ) {
            $title = sprintf( __( 'Output limited to %1$s characters', 'wp-data-access' ), WPDA::get_option( WPDA::OPTION_BE_TEXT_WRAP ) );
            if ( $substitute_newlines ) {
                return str_replace( "\n", '<br/>', substr( esc_html( str_replace( '&', '&amp;', (string) $column_content ) ), 0, WPDA::get_option( WPDA::OPTION_BE_TEXT_WRAP ) ) . ' <a href="javascript:void(0)" title="' . $title . '">&bull;&bull;&bull;</a>' );
            } else {
                return substr( esc_html( str_replace( '&', '&amp;', (string) $column_content ) ), 0, WPDA::get_option( WPDA::OPTION_BE_TEXT_WRAP ) ) . ' <a href="javascript:void(0)" title="' . $title . '">&bull;&bull;&bull;</a>';
            }
        } else {
            $column_data_type = $this->wpda_list_columns->get_column_data_type( $column_name );
            switch ( $column_data_type ) {
                case 'date':
                    // date only.
                    if ( '' === $column_content || null === $column_content ) {
                        $column_content = '';
                    } else {
                        $column_content = date_i18n( get_option( 'date_format' ), strtotime( $column_content ) );
                    }
                    break;
                case 'time':
                    // time only.
                    if ( '' === $column_content || null === $column_content ) {
                        $column_content = '';
                    } else {
                        $column_content = date_i18n( get_option( 'time_format' ), strtotime( $column_content ) );
                    }
                    break;
                case 'datetime':
                // date + time.
                case 'timestamp':
                    if ( '' === $column_content || null === $column_content ) {
                        $column_content = '';
                    } else {
                        $column_content = date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $column_content ) );
                    }
            }
            if ( $substitute_newlines ) {
                return str_replace( "\n", '<br/>', esc_html( str_replace( '&', '&amp;', (string) $column_content ) ) );
            } else {
                return esc_html( str_replace( '&', '&amp;', (string) $column_content ) );
            }
        }
    }

    /**
     * Generate hidden fields for keys
     *
     * @param array $item Column info.
     *
     * @return string String containing key items and values.
     */
    protected function get_key_input_fields( $item ) {
        $key_input_fields = '';
        foreach ( $this->wpda_list_columns->get_table_primary_key() as $key ) {
            $key_name = esc_attr( $key );
            $key_value = esc_attr( $item[$key] );
            $key_input_fields .= "<input type='hidden' name='{$key_name}' value='{$key_value}' />";
        }
        return $key_input_fields;
    }

    /**
     * Override this method to add actions to first column of row
     *
     * @param array  $item Item information.
     * @param string $column_name Column name.
     * @param array  $actions Array of actions to be added to row.
     */
    protected function column_default_add_action( $item, $column_name, &$actions ) {
        if ( has_filter( 'wpda_column_default_add_action' ) ) {
            $filter = apply_filters(
                'wpda_column_default_add_action',
                '',
                $item,
                $column_name,
                $this->table_name,
                $this->schema_name,
                $this->wpda_list_columns,
                self::$list_number,
                $actions,
                $this
            );
            if ( null !== $filter ) {
                $actions = $filter;
            }
        }
    }

    /**
     * Render bulk edit checkbox
     *
     * @param array $item Column list.
     *
     * @return string Content for checkbox column.
     * @since   1.0.0
     */
    public function column_cb( $item ) {
        if ( !$this->bulk_actions_enabled ) {
            // Bulk actions disabled.
            return '';
        }
        if ( empty( $this->wpda_list_columns->get_table_primary_key() ) ) {
            // Table has no primary key: no bulk actions allowed!
            // Primary key is used to ensure uniqueness!
            return '';
        }
        // Build CB value: Use json format for multi column primary keys.
        $cb_value = (object) null;
        foreach ( $this->wpda_list_columns->get_table_primary_key() as $primary_key_column ) {
            // JSON string key and values will be double quoted. Therefore a slash must be added to double quotes in values.
            $cb_value->{$primary_key_column} = esc_attr( str_replace( '"', '\\"', $item[$primary_key_column] ) );
        }
        return "<input type='checkbox' name='bulk-selected[]' value='" . wp_json_encode( $cb_value ) . "' />";
    }

    /**
     * Show page title
     *
     * @return void
     */
    protected function show_title() {
        if ( self::LIST_BASE_TABLE !== $this->table_name && (substr( $this->page, 0, 13 ) === \WP_Data_Access_Admin::PAGE_EXPLORER || \WP_Data_Access_Admin::PAGE_MAIN === $this->page) ) {
            $this->subtitle = $this->title;
            $this->title = 'Data Explorer';
        }
        echo esc_attr( $this->title );
    }

    /**
     * Show page sub title
     *
     * @return void
     */
    protected function show_sub_title() {
        ?>
			<div class="wpda_subtitle"><strong><?php 
        echo wp_kses( $this->subtitle, array(
            'span' => array(
                'class' => array(),
            ),
        ) );
        ?></strong></div>
			<?php 
    }

    /**
     * Show list table page
     *
     * Inside the list table page, the list table is shown. The necessary functionality to show the list table
     * specifically is found in method {@see WPDA_List_Table::display()}.
     *
     * @since   1.0.0
     *
     * @see WPDA_List_Table::display()
     */
    public function show() {
        // Check for import requested.
        if ( null !== $this->wpda_import ) {
            $this->wpda_import->check_post();
        }
        // Prepare list table items.
        $this->prepare_items();
        // Show list table.
        ?>

			<div class="wrap<?php 
        echo ( is_admin() ? '' : ' wp-core-ui' );
        ?>">
				<?php 
        if ( $this->show_page_title ) {
            ?>
				<h1 class="wp-heading-inline">
					<?php 
            if ( self::LIST_BASE_TABLE !== $this->table_name && (WPDA::current_user_is_admin() && \WP_Data_Access_Admin::PAGE_MAIN === $this->page) ) {
                ?>
						<a
							href="?page=<?php 
                echo esc_attr( $this->page );
                ?>"
							class="dashicons dashicons-arrow-left-alt2 wpda_tooltip"
							title="Data Explorer"
						></a>
						<?php 
            }
            $this->show_title();
            ?>
				</h1>
				<?php 
        }
        ?>

				<?php 
        if ( !is_admin() || 'wpda_wpdp_' === substr( $this->page, 0, 10 ) || WPDP::PAGE_TEMPLATES === $this->page || substr( $this->page, 0, 13 ) === \WP_Data_Access_Admin::PAGE_EXPLORER ) {
            $this->add_header_button();
        }
        $this->add_header_actions();
        if ( 'diehard' === $this->page ) {
            $action_url = admin_url( 'admin-ajax.php' );
        } else {
            $action_url = admin_url( 'admin.php' );
        }
        ?>
				<div id="wpda_invisible_container" style="display:none;">
					<form id="wpda_main_export_form" method="post" action="<?php 
        echo esc_url( $action_url );
        ?>?action=wpda_export" target="_blank">
						<input type="text" name="type" id="wpda_main_export_form__type" value="table" />
						<input type="text" name="wpdaschema_name" id="wpda_main_export_form__schema_name" />
						<input type="text" name="_wpnonce" id="wpda_main_export_form__wpnonce" />
					</form>
					<form id="wpda_table_export_form" method="post" action="<?php 
        echo esc_url( $action_url );
        ?>?action=wpda_export" target="_blank">
						<input type="text" name="type" id="wpda_table_export_form__type" value="table" />
						<input type="text" name="wpdaschema_name" id="wpda_table_export_form__schema_name" />
						<input type="text" name="table_names" id="wpda_table_export_form__table_names" />
						<input type="text" name="format_type" id="wpda_table_export_form__format_type" />
						<input type="text" name="include_table_settings" id="wpda_table_export_form__include_table_settings" />
						<input type="text" name="_wpnonce" id="wpda_table_export_form__wpnonce" />
					</form>
					<form id="wpda_row_export_form" method="post" action="<?php 
        echo esc_url( $action_url );
        ?>?action=wpda_export" target="_blank">
						<input type="text" name="type" id="wpda_row_export_form__type" value="row" />
						<input type="text" name="pid" id="wpda_row_export_form__pid" />
						<input type="text" name="wpdaschema_name" id="wpda_row_export_form__schema_name" />
						<input type="text" name="table_names" id="wpda_row_export_form__table_names" />
						<input type="text" name="mysql_set" id="wpda_row_export_form__mysql_set" />
						<input type="text" name="show_create" id="wpda_row_export_form__show_create" />
						<input type="text" name="show_comments" id="wpda_row_export_form__show_comments" />
						<input type="text" name="format_type" id="wpda_row_export_form__format_type" />
						<input type="text" name="_wpnonce" id="wpda_row_export_form__wpnonce" />
					</form>
				</div>
				<?php 
        // Add import container.
        if ( null !== $this->wpda_import ) {
            $this->wpda_import->add_container();
        }
        // Add custom code before the list table.
        do_action_ref_array( 'wpda_before_list_table', array($this) );
        // Prepare url.
        if ( is_admin() ) {
            $url = "?page={$this->page}";
        } else {
            $url = '';
        }
        ?>

				<form	id="wpda_main_form"
						method="post"
						action="<?php 
        echo esc_attr( $url );
        ?>"
						style="
						<?php 
        if ( '' !== $this->subtitle ) {
            echo 'margin-top: 10px';
        }
        ?>
						"
				>

					<?php 
        $this->show_sub_title();
        if ( $this->search_box_enabled ) {
            $this->search_box( __( 'search', 'wp-data-access' ), 'search_id' );
        }
        $this->display();
        if ( '' === $this->get_bulk_actions() ) {
            // Add action item containing value -1. This will allow sorting if no bulk action listbox is displayed.
            ?>
						<input type="hidden" name="action" value="-1"/>
						<?php 
        }
        if ( self::LIST_BASE_TABLE !== $this->table_name ) {
            ?>
						<input type="hidden" name="wpdaschema_name"
							   value="<?php 
            echo esc_attr( $this->schema_name );
            // input var okay.
            ?>"/>
						<input type="hidden" name="table_name"
							   value="<?php 
            echo esc_attr( $this->table_name );
            // input var okay.
            ?>"/>
						<?php 
        }
        ?>
					<input id="wpda_main_form_orderby" type="hidden" name="orderby"
						   value="<?php 
        echo ( isset( $_REQUEST['orderby'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['orderby'] ) ) ) : '' );
        // input var okay.
        ?>"/>
					<input id="wpda_main_form_order" type="hidden" name="order"
						   value="<?php 
        echo ( isset( $_REQUEST['order'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['order'] ) ) ) : '' );
        // input var okay.
        ?>"/>
					<input id="wpda_main_form_post_mime_type" type="hidden" name="post_mime_type"
						   value="<?php 
        echo ( isset( $_REQUEST['post_mime_type'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['post_mime_type'] ) ) ) : '' );
        // input var okay.
        ?>"/>
					<input id="wpda_main_form_detached" type="hidden" name="detached"
						   value="<?php 
        echo ( isset( $_REQUEST['detached'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['detached'] ) ) ) : '' );
        // input var okay.
        ?>"/>
					<input id="wpda_main_db_schema" type="hidden" name="wpda_main_db_schema"
						   value="<?php 
        echo ( isset( $_REQUEST['wpda_main_db_schema'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['wpda_main_db_schema'] ) ) ) : '' );
        // input var okay.
        ?>"/>
					<input id="wpda_main_favourites" type="hidden" name="wpda_main_favourites"
						   value="<?php 
        echo ( isset( $_REQUEST['wpda_main_favourites'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['wpda_main_favourites'] ) ) ) : '' );
        // input var okay.
        ?>"/>
					<?php 
        wp_nonce_field( 'wpda-export-' . wp_json_encode( $this->table_name ), '_wpnonce', false );
        ?>
					<?php 
        wp_nonce_field( "wpda-delete-{$this->table_name}", '_wpnonce2', false );
        ?>
					<?php 
        if ( self::LIST_BASE_TABLE === $this->table_name ) {
            wp_nonce_field( 'wpda-drop-' . WPDA::get_current_user_login(), '_wpnonce3', false );
            wp_nonce_field( 'wpda-truncate-' . WPDA::get_current_user_login(), '_wpnonce4', false );
        }
        ?>
					<?php 
        foreach ( $_REQUEST as $key => $value ) {
            if ( substr( $key, 0, 19 ) === 'wpda_search_column_' ) {
                if ( is_array( $value ) ) {
                    foreach ( $value as $elem_key => $elem_value ) {
                        echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $elem_value ) . '"/>';
                    }
                } else {
                    echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '"/>';
                }
            }
        }
        ?>
				</form>
			</div>
			<script type='text/javascript'>
				jQuery(function() {
					jQuery( '.wpda_tooltip' ).tooltip();
					// Add toolbar events
					jQuery("#wpda_toolbar_icon_go_backup").on("click", function() {
						jQuery("#wpda_goto_backup").submit();
					});
					jQuery("#wpda_toolbar_icon_add_row").on("click", function() {
						jQuery("#wpda_new_row_table_name").val("<?php 
        echo esc_attr( $this->table_name );
        ?>");
						jQuery("#wpda_new_row").submit();
					});
					jQuery("#wpda_toolbar_icon_add_publication").on("click", function() {
						jQuery("#wpda_new_publication_table_name").val("<?php 
        echo esc_attr( $this->table_name );
        ?>");
						jQuery("#wpda_new_publication").submit();
					});
				});
			</script>
			<?php 
        $this->bind_action_buttons();
        ?>
			<?php 
        // Add custom code after the list table.
        do_action_ref_array( 'wpda_after_list_table', array($this) );
    }

    /**
     * Placeholder for subclasses to add additional actions
     *
     * @return void
     */
    protected function add_header_actions() {
    }

    /**
     * Bind javascript code to action buttons
     *
     * @since   1.6.2
     */
    protected function bind_action_buttons() {
        ?>
			<script type='text/javascript'>
				jQuery(function () {
					jQuery("#doaction").click(function () {
						return wpda_action_button();
					});
					jQuery("#doaction2").click(function () {
						return wpda_action_button();
					});
				});
			</script>
			<?php 
    }

    /**
     * Add button to page header
     *
     * By default "add new" and "import" buttons are added (depending on the settings). Overwrite this method to
     * add your own buttons.
     *
     * @since   1.0.1
     */
    protected function add_header_button() {
        if ( 'off' === $this->allow_insert ) {
            if ( null !== $this->wpda_import ) {
                $this->wpda_import->add_button();
            }
        } else {
            //phpcs:ignore - 8.1 proof
            if ( WPDA::is_wpda_table( $this->table_name ) || ('on' === WPDA::get_option( WPDA::OPTION_BE_ALLOW_INSERT ) && count( $this->wpda_list_columns->get_table_primary_key() )) > 0 ) {
                $storage_type = ( WPDA::is_wpda_table( $this->table_name ) ? __( 'respository', 'wp-data-access' ) : __( 'table', 'wp-data-access' ) );
                // Prepare url.
                if ( is_admin() ) {
                    $url = "?page={$this->page}";
                } else {
                    $url = '';
                }
                ?>
					<form
							method="post"
							action="<?php 
                echo esc_attr( $url );
                ?>"
							style="display: inline-block; vertical-align: baseline;"
					>
						<div>
							<input type="hidden" name="wpdaschema_name"
								   value="<?php 
                echo esc_attr( $this->schema_name );
                // input var okay.
                ?>"/>
							<input type="hidden" name="table_name"
								   value="<?php 
                echo esc_attr( $this->table_name );
                // input var okay.
                ?>"/>
							<input type="hidden" name="action" value="new">
							<button type="submit" class="page-title-action wpda_tooltip"
									title="<?php 
                echo sprintf( __( 'Add new %1$s to %2$s', 'wp-data-access' ), esc_attr( $this->_args['singular'] ), esc_attr( $storage_type ) );
                ?>"
							>
								<i class="fas fa-plus-circle wpda_icon_on_button"></i>
								<?php 
                echo __( 'Add New', 'wp-data-access' );
                ?>
							</button>
							<?php 
                // Add import button to title.
                if ( null !== $this->wpda_import ) {
                    $this->wpda_import->add_button();
                }
                ?>
						</div>
					</form>
					<?php 
            } else {
                // Add import button to title.
                if ( null !== $this->wpda_import ) {
                    $this->wpda_import->add_button();
                }
            }
        }
    }

    /**
     * Prepares the list of items for displaying
     *
     * Overwrites WP_List_Table::prepare_items()
     *
     * @since   1.0.0
     */
    public function prepare_items() {
        // Construct where clause with search values provided in the search box.
        // Result (where clause) is written to $this->where.
        $this->construct_where_clause();
        $this->process_bulk_action();
        if ( is_admin() ) {
            if ( $this->table_name === self::LIST_BASE_TABLE ) {
                $option = 'wpda_rows_per_page_' . str_replace( '.', '_', self::LIST_BASE_TABLE );
            } else {
                $option = 'wpda_rows_per_page_' . str_replace( '.', '_', $this->schema_name . $this->table_name );
            }
            $this->items_per_page = $this->get_items_per_page( $option, WPDA::get_option( WPDA::OPTION_BE_PAGINATION ) );
        } else {
            $this->items_per_page = WPDA::get_option( WPDA::OPTION_FE_PAGINATION );
        }
        $this->current_page = $this->get_pagenum();
        $total_items = $this->record_count();
        $total_pages = ceil( $total_items / $this->items_per_page );
        if ( $this->search_value !== $this->search_value_old ) {
            $this->current_page = 1;
        }
        if ( $this->current_page > $total_pages ) {
            $this->current_page = $total_pages;
        }
        $this->set_pagination_args( array(
            'total_items' => $total_items,
            'total_pages' => $total_pages,
            'per_page'    => $this->items_per_page,
        ) );
        $this->get_rows();
        // Written to $this->items in base class (WP_List_Table).
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        if ( false === $hidden ) {
            if ( is_admin() ) {
                // List table in backend.
                if ( self::LIST_BASE_TABLE === $this->table_name ) {
                    $table_name = str_replace( '.', '_', self::LIST_BASE_TABLE );
                } else {
                    global $wpdb;
                    if ( $this->schema_name === $wpdb->dbname && WPDA_CSV_Uploads_Model::get_base_table_name() === $this->table_name ) {
                        $table_name = $this->table_name;
                        // csv upload = exception.
                    } else {
                        $table_name = str_replace( '.', '_', $this->schema_name . $this->table_name );
                    }
                }
                $hidden = get_user_option( WPDA_List_View::HIDDENCOLUMNS_PREFIX . get_current_screen()->id . $table_name );
                if ( false === $hidden ) {
                    $hidden = array();
                }
            }
        }
        if ( !is_array( $hidden ) ) {
            $hidden = array();
        }
        $sortable = $this->get_sortable_columns();
        $primary = $this->get_primary_column();
        $this->_column_headers = array(
            $columns,
            $hidden,
            $sortable,
            $primary
        );
    }

    /**
     * Build where clause
     *
     * Arguments might come from the URL so we need to check for SQL injection and use prepare. The resulting
     * where clause is written directly to member $this->where.
     *
     * @since   1.0.0
     */
    protected function construct_where_clause() {
        $whereclause = $this->get_where_clause();
        if ( '' !== $whereclause ) {
            $this->where = ( '' === $this->where ? " where ({$whereclause}) " : " {$this->where} and ({$whereclause}) " );
        }
    }

    /**
     * Returns the where clause (uses filters if available)
     *
     * @return string
     */
    public function get_where_clause() {
        return WPDA::construct_where_clause(
            $this->schema_name,
            $this->table_name,
            $this->wpda_list_columns->get_searchable_table_columns(),
            $this->search_value,
            isset( $_REQUEST['wpda_c'] ) && 'true' === $_REQUEST['wpda_c']
        );
    }

    /**
     * Process bulk actions
     *
     * Delete and bulk-delete actions use the primary key list as a reference. Before performing the actual delete
     * statement(s) we'll check the provided column names against the data dictionary. This will protect us against
     * SQL injection attacks.
     *
     * For export actions table names will not be checked here. They are handed over WPDA_Export where the validity
     * and access rights are checked anyway (to be safe).
     *
     * All actions can be processed only with a valid wpnonce value.
     *
     * To perform actions the user must have the appropriate rights.
     *
     * @since   1.0.0
     */
    public function process_bulk_action() {
        switch ( $this->current_action() ) {
            case 'delete':
                // Check access rights.
                if ( 'on' !== $this->allow_delete ) {
                    // Deleting records from list table is not allowed.
                    wp_die( __( 'ERROR: Not authorized [delete not allowed]', 'wp-data-access' ) );
                }
                // Prepare wp_nonce action security check.
                $wp_nonce_action = "wpda-delete-{$this->table_name}";
                $row_to_be_deleted = array();
                // Gonna hold the row to be deleted.
                $i = 0;
                // Index, necessary for multi column keys.
                // Check all key columns.
                foreach ( $this->wpda_list_columns->get_table_primary_key() as $key ) {
                    // Check if key is available.
                    if ( !isset( $_REQUEST[$key] ) ) {
                        // input var okay.
                        wp_die( __( 'ERROR: Invalid URL [missing primary key values]', 'wp-data-access' ) );
                    }
                    // Write key value pair to array.
                    $row_to_be_deleted[$i]['key'] = $key;
                    $row_to_be_deleted[$i]['value'] = sanitize_text_field( wp_unslash( $_REQUEST[$key] ) );
                    // input var okay.
                    $i++;
                    // Add key values to wp_nonce action.
                    $wp_nonce_action .= '-' . sanitize_text_field( wp_unslash( $_REQUEST[$key] ) );
                    // input var okay.
                }
                // Check if delete is allowed.
                $wp_nonce = ( isset( $_REQUEST['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ) : '' );
                // input var okay.
                if ( !wp_verify_nonce( $wp_nonce, $wp_nonce_action ) ) {
                    wp_die( __( 'ERROR: Not authorized', 'wp-data-access' ) );
                }
                // All key column values available: delete record.
                // Prepare named array for delete operation.
                $next_row_to_be_deleted = array();
                $count_rows = count( $row_to_be_deleted );
                //phpcs:ignore - 8.1 proof
                for ($i = 0; $i < $count_rows; $i++) {
                    $next_row_to_be_deleted[$row_to_be_deleted[$i]['key']] = $row_to_be_deleted[$i]['value'];
                }
                $engine = WPDA::get_table_engine( $this->schema_name, $this->table_name );
                if ( $this->delete_row( $next_row_to_be_deleted, $engine ) ) {
                    $msg = new WPDA_Message_Box(array(
                        'message_text' => __( 'Row deleted', 'wp-data-access' ),
                    ));
                    $msg->box();
                } else {
                    $msg = new WPDA_Message_Box(array(
                        'message_text'           => __( 'Could not delete row', 'wp-data-access' ),
                        'message_type'           => 'error',
                        'message_is_dismissible' => false,
                    ));
                    $msg->box();
                }
                break;
            case 'bulk-delete':
                // Check access rights.
                if ( 'on' !== $this->allow_delete ) {
                    // Deleting records from list table is not allowed.
                    die( __( 'ERROR: Not authorized [delete not allowed]', 'wp-data-access' ) );
                }
                // We first need to check if all the necessary information is available.
                if ( !isset( $_REQUEST['bulk-selected'] ) ) {
                    // input var okay.
                    // Nothing to delete.
                    $msg = new WPDA_Message_Box(array(
                        'message_text' => __( 'Nothing to delete', 'wp-data-access' ),
                    ));
                    $msg->box();
                    return;
                }
                // Check if delete is allowed.
                $wp_nonce_action = "wpda-delete-{$this->table_name}";
                $wp_nonce = ( isset( $_REQUEST['_wpnonce2'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce2'] ) ) : '' );
                // input var okay.
                if ( !wp_verify_nonce( $wp_nonce, $wp_nonce_action ) ) {
                    die( __( 'ERROR: Not authorized', 'wp-data-access' ) );
                }
                $bulk_rows = (array) $_REQUEST['bulk-selected'];
                // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
                $no_rows = count( $bulk_rows );
                // # rows to be deleted. //phpcs:ignore - 8.1 proof being safe
                $rows_to_be_deleted = array();
                // Gonna hold rows to be deleted.
                for ($i = 0; $i < $no_rows; $i++) {
                    // Write "json" to named array. Need to strip slashes twice. Once for the normal conversion
                    // and once extra for the pre-conversion of double quotes in method column_cb().
                    $row_object = json_decode( stripslashes( stripslashes( $bulk_rows[$i] ) ), true );
                    if ( $row_object ) {
                        $j = 0;
                        // Index used to build array.
                        // Check all key columns.
                        foreach ( $this->wpda_list_columns->get_table_primary_key() as $key ) {
                            // Check if key is available.
                            if ( !isset( $row_object[$key] ) ) {
                                wp_die( __( 'ERROR: Invalid URL [missing primary key values]', 'wp-data-access' ) );
                            }
                            // Write key value pair to array.
                            $rows_to_be_deleted[$i][$j]['key'] = $key;
                            $rows_to_be_deleted[$i][$j]['value'] = $row_object[$key];
                            $j++;
                        }
                    }
                }
                // Looks like everything is there. Delete records from table...
                $no_key_cols = count( $this->wpda_list_columns->get_table_primary_key() );
                //phpcs:ignore - 8.1 proof
                $rows_successfully_deleted = 0;
                // Number of rows successfully deleted.
                $rows_with_errors = 0;
                // Number of rows that could not be deleted.
                $engine = WPDA::get_table_engine( $this->schema_name, $this->table_name );
                for ($i = 0; $i < $no_rows; $i++) {
                    // Prepare named array for delete operation.
                    $next_row_to_be_deleted = array();
                    $row_found = true;
                    for ($j = 0; $j < $no_key_cols; $j++) {
                        if ( isset( $rows_to_be_deleted[$i][$j]['key'] ) ) {
                            $next_row_to_be_deleted[$rows_to_be_deleted[$i][$j]['key']] = $rows_to_be_deleted[$i][$j]['value'];
                        } else {
                            $row_found = false;
                        }
                    }
                    if ( $row_found ) {
                        if ( $this->delete_row( $next_row_to_be_deleted, $engine ) ) {
                            // Row(s) successfully deleted.
                            $rows_successfully_deleted++;
                        } else {
                            // An error occurred during the delete operation: increase error count.
                            $rows_with_errors++;
                        }
                    } else {
                        // An error occurred during the delete operation: increase error count.
                        $rows_with_errors++;
                    }
                }
                // Inform user about the results of the operation.
                $message = '';
                if ( 1 === $rows_successfully_deleted ) {
                    $message = __( 'Row deleted', 'wp-data-access' );
                } elseif ( $rows_successfully_deleted > 1 ) {
                    $message = "{$rows_successfully_deleted} " . __( 'rows deleted', 'wp-data-access' );
                }
                if ( '' !== $message ) {
                    $msg = new WPDA_Message_Box(array(
                        'message_text' => $message,
                    ));
                    $msg->box();
                }
                $message = '';
                if ( $rows_with_errors > 0 ) {
                    $message = __( 'Not all rows have been deleted', 'wp-data-access' );
                }
                if ( '' !== $message ) {
                    $msg = new WPDA_Message_Box(array(
                        'message_text'           => $message,
                        'message_type'           => 'error',
                        'message_is_dismissible' => false,
                    ));
                    $msg->box();
                }
                break;
            case 'bulk-export':
            case 'bulk-export-xml':
            case 'bulk-export-json':
            case 'bulk-export-excel':
            case 'bulk-export-csv':
                // Check access rights.
                if ( !WPDA::is_wpda_table( $this->table_name ) ) {
                    if ( 'on' !== WPDA::get_option( WPDA::OPTION_BE_EXPORT_ROWS ) ) {
                        // Exporting rows from list table is not allowed.
                        die( __( 'ERROR: Not authorized [export not allowed]', 'wp-data-access' ) );
                    }
                }
                // We first need to check if all the necessary information is available.
                if ( !isset( $_REQUEST['bulk-selected'] ) ) {
                    // input var okay.
                    // Nothing to export.
                    $msg = new WPDA_Message_Box(array(
                        'message_text' => __( 'Nothing to export', 'wp-data-access' ),
                    ));
                    $msg->box();
                    return;
                }
                // Check if export is allowed.
                $wp_nonce = ( isset( $_REQUEST['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ) : '' );
                // input var okay.
                if ( !wp_verify_nonce( $wp_nonce, 'wpda-export-' . wp_json_encode( $this->table_name ) ) ) {
                    die( __( 'ERROR: Not authorized', 'wp-data-access' ) );
                }
                $bulk_rows = (array) $_REQUEST['bulk-selected'];
                // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
                $no_rows = count( $bulk_rows );
                // # rows to be exported. //phpcs:ignore - 8.1 proof being safe
                $format_type = '';
                switch ( $this->current_action() ) {
                    case 'bulk-export-xml':
                        $format_type = 'xml';
                        break;
                    case 'bulk-export-json':
                        $format_type = 'json';
                        break;
                    case 'bulk-export-excel':
                        $format_type = 'excel';
                        break;
                    case 'bulk-export-csv':
                        $format_type = 'csv';
                }
                if ( 'diehard' === $this->page && null !== $this->pid ) {
                    $wp_nonce = wp_create_nonce( "wpda-export-{$this->pid}" );
                    $submit_schema_name = '';
                    $submit_table_name = '';
                } else {
                    $submit_schema_name = $this->schema_name;
                    $submit_table_name = $this->table_name;
                }
                $j = 0;
                $columns = array();
                for ($i = 0; $i < $no_rows; $i++) {
                    // Write "json" to named array. Need to strip slashes twice. Once for the normal conversion
                    // and once extra for the pre-conversion of double quotes in method column_cb().
                    $row_object = json_decode( stripslashes( stripslashes( $bulk_rows[$i] ) ), true );
                    if ( $row_object ) {
                        // Check all key columns.
                        foreach ( $this->wpda_list_columns->get_table_primary_key() as $key ) {
                            // Check if key is available.
                            if ( !isset( $row_object[$key] ) ) {
                                wp_die( __( 'ERROR: Invalid URL', 'wp-data-access' ) );
                            }
                            if ( !isset( $columns[$key] ) ) {
                                $columns[$key] = array();
                            }
                            $columns[$key][] = $row_object[$key];
                        }
                        $j++;
                    }
                }
                ?>
					<script type="application/javascript">
						jQuery(function() {
							wpda_row_export(
								'<?php 
                echo esc_attr( $this->pid );
                ?>',
								'<?php 
                echo esc_attr( $submit_schema_name );
                ?>',
								'<?php 
                echo esc_attr( $submit_table_name );
                ?>',
								'<?php 
                echo esc_attr( $wp_nonce );
                ?>',
								'<?php 
                echo esc_attr( $format_type );
                ?>',
								'off',
								'off',
								'off',
								'<?php 
                echo wp_json_encode( $columns );
                ?>'
							);
						});
					</script>
					<?php 
        }
    }

    /**
     * Delete record from database table
     *
     * The table must have a primary key and the values for all primary key columns must be provided in the
     * request. The where clause must be a named array in format: ['column_name'] = 'value'
     *
     * @param string $where where clause.
     * @param string $engine connect or empty.
     *
     * @return mixed
     * @since   1.0.0
     */
    public function delete_row( $where, $engine = '' ) {
        $wpdadb = WPDADB::get_db_connection( $this->schema_name );
        if ( null === $wpdadb ) {
            if ( is_admin() ) {
                wp_die( sprintf( __( 'ERROR - Remote database %s not available', 'wp-data-access' ), esc_attr( $this->schema_name ) ) );
            } else {
                die( sprintf( __( 'ERROR - Remote database %s not available', 'wp-data-access' ), esc_attr( $this->schema_name ) ) );
            }
        }
        $row_deleted = $wpdadb->delete( $this->table_name, $where );
        if ( 'connect' === strtolower( $engine ) ) {
            // Connect engine does not return number of rows deleted.
            // Presuming delete was successful when no error message was returned.
            return '' === $wpdadb->last_error;
        }
        return $row_deleted;
    }

    /**
     * Number of records in database table
     *
     * Returns the number of records in the database table. Where clause must be prepared in advance and written
     * to $this->where ({@see WPDA_List_Table::construct_where_clause()})
     *
     * @return null|string Number of rows in the current table
     * @since   1.0.0
     */
    public function record_count() {
        if ( !$this->row_count_estimate['do_real_count'] && '' === $this->where ) {
            // Use estimate row count.
            return $this->table_rows;
        }
        // Get real row count.
        $wpdadb = WPDADB::get_db_connection( $this->schema_name );
        if ( null === $wpdadb ) {
            if ( is_admin() ) {
                wp_die( sprintf( __( 'ERROR - Remote database %s not available', 'wp-data-access' ), esc_attr( $this->schema_name ) ) );
            } else {
                die( sprintf( __( 'ERROR - Remote database %s not available', 'wp-data-access' ), esc_attr( $this->schema_name ) ) );
            }
        }
        if ( '' === $this->schema_name ) {
            $query = "\n\t\t\t\t\tselect count(*)\n\t\t\t\t\tfrom `{$this->table_name}`\n\t\t\t\t\t{$this->where}\n\t\t\t\t";
        } else {
            if ( self::LIST_BASE_TABLE === $this->table_name ) {
                $query = "\n\t\t\t\t\t\tselect count(*)\n\t\t\t\t\t\tfrom {$this->table_name}\n\t\t\t\t\t\t{$this->where}\n\t\t\t\t\t";
            } else {
                $query = "\n\t\t\t\t\t\tselect count(*)\n\t\t\t\t\t\tfrom `{$wpdadb->dbname}`.`{$this->table_name}`\n\t\t\t\t\t\t{$this->where}\n\t\t\t\t\t";
            }
        }
        return $wpdadb->get_var( $query );
        // phpcs:ignore Standard.Category.SniffName.ErrorCode
    }

    /**
     * Perform query to retrieve rows from database
     *
     * Where clause must be prepared in advance and written to $this->where
     * ({@see WPDA_List_Table::construct_where_clause()}).
     *
     * No return value. Result is directly written to $this->items (base class member).
     *
     * @since   1.0.0
     */
    public function get_rows() {
        $wpdadb = WPDADB::get_db_connection( $this->schema_name );
        if ( null === $wpdadb ) {
            if ( is_admin() ) {
                wp_die( sprintf( __( 'ERROR - Remote database %s not available', 'wp-data-access' ), esc_attr( $this->schema_name ) ) );
            } else {
                die( sprintf( __( 'ERROR - Remote database %s not available', 'wp-data-access' ), esc_attr( $this->schema_name ) ) );
            }
        }
        // Selected columns cannot be changed by the user at this time. No check for SQL injection needed now.
        // This might change in the future when users are allowed to change or set this value. A method named
        // column_exists() in WPDA_Dictionary_Checks is already available for this purpose.
        $selected_columns = '*';
        if ( isset( $this->columns_queried ) ) {
            $selected_columns = implode( ',', $this->columns_queried );
        }
        if ( isset( $this->wpda_table_settings->hyperlinks ) ) {
            $i = 0;
            foreach ( $this->wpda_table_settings->hyperlinks as $hyperlink ) {
                $skip_column = false;
                if ( null !== $this->wpda_project_table_settings ) {
                    $hyperlink_label = $hyperlink->hyperlink_label;
                    if ( !property_exists( $this, 'is_child' ) ) {
                        if ( isset( $this->wpda_project_table_settings->hyperlinks_parent->{$hyperlink_label} ) && !$this->wpda_project_table_settings->hyperlinks_parent->{$hyperlink_label} ) {
                            $skip_column = true;
                        }
                    } else {
                        if ( isset( $this->wpda_project_table_settings->hyperlinks_child->{$hyperlink_label} ) && !$this->wpda_project_table_settings->hyperlinks_child->{$hyperlink_label} ) {
                            $skip_column = true;
                        }
                    }
                }
                if ( !$skip_column && isset( $hyperlink->hyperlink_list ) && true === $hyperlink->hyperlink_list ) {
                    $hyperlink_label = ( isset( $hyperlink->hyperlink_label ) ? $hyperlink->hyperlink_label : '' );
                    $hyperlink_html = ( isset( $hyperlink->hyperlink_html ) ? $hyperlink->hyperlink_html : '' );
                    if ( '' !== $hyperlink_label && '' !== $hyperlink_html ) {
                        // Add hyperlink columns (details are added in method column_default).
                        $selected_columns .= ", '' as wpda_hyperlink_{$i}";
                    }
                }
                $i++;
            }
        }
        if ( '' === $this->schema_name ) {
            $query = "\n\t\t\t\t\tselect {$selected_columns}\n\t\t\t\t\tfrom `{$this->table_name}`\n\t\t\t\t\t{$this->where}\n\t\t\t\t";
        } else {
            if ( self::LIST_BASE_TABLE === $this->table_name ) {
                $query = "\n\t\t\t\t\t\tselect {$selected_columns}\n\t\t\t\t\t\tfrom {$this->table_name}\n\t\t\t\t\t\t{$this->where}\n\t\t\t\t\t";
            } else {
                $query = "\n\t\t\t\t\t\tselect {$selected_columns}\n\t\t\t\t\t\tfrom `{$wpdadb->dbname}`.`{$this->table_name}`\n\t\t\t\t\t\t{$this->where}\n\t\t\t\t\t";
            }
        }
        $query .= $this->get_order_by();
        // Add order by.
        $query .= " limit {$this->items_per_page}";
        $offset = ($this->current_page - 1) * $this->items_per_page;
        if ( $offset > 0 ) {
            $query .= " offset {$offset}";
        }
        // Debug query.
        // var_dump( $query );
        $this->items = $wpdadb->get_results( $query, 'ARRAY_A' );
        // phpcs:ignore Standard.Category.SniffName.ErrorCode
    }

    /**
     * Get order by
     *
     * @return string|void
     */
    protected function get_order_by() {
        if ( !empty( $_REQUEST['orderby'] ) ) {
            $orderby_arg = sanitize_sql_orderby( wp_unslash( $_REQUEST['orderby'] ) );
            // input var okay.
            if ( !empty( $_REQUEST['order'] ) ) {
                $order_arg = sanitize_text_field( wp_unslash( $_REQUEST['order'] ) );
                // input var okay.
            } else {
                $order_arg = '';
            }
            $columns = $this->get_sortable_columns();
            // Check column name for SQL injection.
            if ( isset( $columns[$orderby_arg] ) || $this->wpda_data_dictionary->column_exists( $orderby_arg ) ) {
                // Column name exists in current table, safely continue...
                $orderby = " order by {$orderby_arg}";
                // Prevent SQL injection for order. If 'desc' is found result will be ordered desc. In all other
                // cases we'll order asc.
                $orderby .= ( strtolower( trim( $order_arg ) ) === 'desc' ? ' desc' : ' asc' );
                return $orderby;
            } else {
                // The user provided a column name which is not in the table. Most probably the result of a
                // SQL injection attack, so let's terminate.
                wp_die( __( 'ERROR: Invalid URL [invalid column name]', 'wp-data-access' ) );
            }
        } else {
            return '';
        }
    }

    /**
     * Return an associative array of columns
     *
     * @return array
     * @since   1.0.0
     */
    public function get_columns() {
        if ( null !== $this->wpda_cached_columns && is_array( $this->wpda_cached_columns ) ) {
            return $this->wpda_cached_columns;
        }
        $columns = array();
        if ( $this->bulk_actions_enabled ) {
            if ( !empty( $this->wpda_list_columns->get_table_primary_key() ) ) {
                // Tables has primary key: bulk actions allowed!
                // Primary key is used to ensure uniqueness.
                $actions = $this->get_bulk_actions();
                if ( is_array( $actions ) && 0 < count( $actions ) ) {
                    //phpcs:ignore - 8.1 proof
                    $columns = array(
                        'cb' => '<input type="checkbox" />',
                    );
                }
            }
        }
        $columnlist = $this->wpda_list_columns->get_table_column_headers();
        foreach ( $columnlist as $key => $value ) {
            $columns[$key] = $value;
            // Check for alternative column header.
            if ( isset( $this->column_headers[$key] ) ) {
                // Alternative header found: use it.
                $columns[$key] = $this->column_headers[$key];
            } else {
                // Default behaviour: get column header from generated label.
                $columns[$key] = $this->wpda_list_columns->get_column_label( $key );
            }
        }
        if ( isset( $this->wpda_table_settings->hyperlinks ) ) {
            $i = 0;
            foreach ( $this->wpda_table_settings->hyperlinks as $hyperlink ) {
                if ( isset( $hyperlink->hyperlink_list ) && true === $hyperlink->hyperlink_list ) {
                    $skip_column = false;
                    if ( null !== $this->wpda_project_table_settings ) {
                        $hyperlink_label = $hyperlink->hyperlink_label;
                        if ( !property_exists( $this, 'is_child' ) ) {
                            if ( isset( $this->wpda_project_table_settings->hyperlinks_parent->{$hyperlink_label} ) && !$this->wpda_project_table_settings->hyperlinks_parent->{$hyperlink_label} ) {
                                $skip_column = true;
                            }
                        } else {
                            if ( isset( $this->wpda_project_table_settings->hyperlinks_child->{$hyperlink_label} ) && !$this->wpda_project_table_settings->hyperlinks_child->{$hyperlink_label} ) {
                                $skip_column = true;
                            }
                        }
                    }
                    if ( !$skip_column ) {
                        $hyperlink_label = ( isset( $hyperlink->hyperlink_label ) ? $hyperlink->hyperlink_label : '' );
                        $columns["wpda_hyperlink_{$i}"] = $hyperlink_label;
                        // Add hyperlink label.
                    }
                }
                $i++;
            }
        }
        // Cache columns.
        $this->wpda_cached_columns = $columns;
        return $columns;
    }

    /**
     * List of columns to make sortable
     *
     * @return array
     * @since   1.0.0
     */
    public function get_sortable_columns() {
        $columns = array();
        // Get column names from result set.
        if ( $this->items ) {
            foreach ( $this->items[0] as $key => $value ) {
                if ( 'wpda_hyperlink_' !== substr( $key, 0, 15 ) ) {
                    $columns[$key] = array($key, false);
                }
            }
        }
        return $columns;
    }

    /**
     * Display the search box
     *
     * @param string $text The 'submit' button label.
     * @param string $input_id ID attribute value for the search input field.
     *
     * @since   1.0.0
     */
    public function search_box( $text, $input_id ) {
        $input_id = $input_id . '-search-input';
        // Allow external user to add search actions (like icons) to the search box.
        do_action(
            'wpda_add_search_actions',
            $this->schema_name,
            $this->table_name,
            $this->wpda_table_settings,
            $this->wpda_list_columns
        );
        ?>

			<p class="search-box" <?php 
        echo ( !$this->has_items() ? 'style="padding-bottom:10px;"' : '' );
        ?>>
				<input type="search" id="<?php 
        echo esc_attr( $input_id );
        ?>"
					   name="<?php 
        echo esc_attr( $this->search_item_name );
        ?>"
					   value="<?php 
        echo esc_attr( $this->search_value );
        ?>"/>
				<?php 
        if ( is_admin() ) {
            submit_button(
                $text,
                '',
                '',
                false,
                array(
                    'id' => 'search-submit',
                )
            );
        } else {
            wpdadiehard_submit_button(
                $text,
                '',
                '',
                false,
                array(
                    'id' => 'search-submit',
                )
            );
        }
        ?>
				<input type="hidden" name="<?php 
        echo esc_attr( $this->search_item_name );
        ?>_old_value"
					   value="<?php 
        echo esc_attr( $this->search_value );
        ?>"/>
			</p>

			<?php 
        // Allow external user to add search html (like extra items) below the search box.
        do_action(
            'wpda_add_search_filter',
            $this->schema_name,
            $this->table_name,
            $this->wpda_table_settings,
            $this->wpda_list_columns
        );
    }

    /**
     * Get search value (entered by the user or taken from cookie).
     *
     * @return string
     * @since   1.5.0
     */
    protected function get_search_value() {
        if ( 'off' === WPDA::get_option( WPDA::OPTION_BE_REMEMBER_SEARCH ) ) {
            if ( isset( $_REQUEST[$this->search_item_name] ) ) {
                return wp_filter_nohtml_kses( wp_unslash( $_REQUEST[$this->search_item_name] ) );
                // input var okay.
            }
        }
        if ( 'wpda_wpdp_' === substr( $this->page, 0, 10 ) ) {
            $cookie_name = $this->page;
            if ( isset( $_REQUEST['child_request'] ) ) {
                $cookie_name = 'NOCOOKIESFORCHILDREQUESTS';
                // No search values stored for child tables.
            }
            foreach ( $_REQUEST as $key => $val ) {
                if ( strpos( $key, 'WPDA_PARENT_KEY*' ) === 0 ) {
                    $cookie_name = 'NOCOOKIESFORCHILDREQUESTS';
                    // No search values stored for child tables.
                }
            }
        } else {
            $cookie_name = $this->page . '_search_' . str_replace( '.', '_', $this->table_name );
        }
        if ( isset( $_REQUEST[$this->search_item_name] ) && '' !== $_REQUEST[$this->search_item_name] ) {
            // input var okay.
            return wp_filter_nohtml_kses( wp_unslash( $_REQUEST[$this->search_item_name] ) );
            // input var okay.
        } elseif ( isset( $_COOKIE[$cookie_name] ) ) {
            return wp_filter_nohtml_kses( wp_unslash( $_COOKIE[$cookie_name] ) );
            // input var okay.
        } else {
            return null;
        }
    }

    /**
     * Print column headers
     *
     * Overriding original method print_column_headers to support post instead of get.
     * Changes are marked!
     *
     * @param boolean $with_id Whether to set the id attribute or not.
     *
     * @since   1.0.0
     *
     * @staticvar $cb_counter int
     */
    public function print_column_headers( $with_id = true ) {
        list( $columns, $hidden, $sortable, $primary ) = $this->get_column_info();
        //phpcs:ignore - 8.1 proof
        // *********************
        // *** BEGIN CHANGES ***
        // *********************
        // Code removed.
        // *******************
        // *** END CHANGES ***
        // *******************
        if ( isset( $_REQUEST['orderby'] ) ) {
            $current_orderby = sanitize_text_field( wp_unslash( $_REQUEST['orderby'] ) );
            // input var okay.
        } else {
            $current_orderby = '';
        }
        if ( isset( $_REQUEST['order'] ) && 'desc' === $_REQUEST['order'] ) {
            // input var okay.
            $current_order = 'desc';
        } else {
            $current_order = 'asc';
        }
        if ( !empty( $columns['cb'] ) ) {
            static $cb_counter = 1;
            $columns['cb'] = '<label class="screen-reader-text" for="cb-select-all-' . $cb_counter . '">' . __( 'Select All' ) . '</label>' . '<input id="cb-select-all-' . $cb_counter . '" type="checkbox" />';
            $cb_counter++;
        }
        foreach ( $columns as $column_key => $column_display_name ) {
            $class = array('manage-column', "column-{$column_key}");
            if ( in_array( $column_key, (array) $hidden ) ) {
                //phpcs:ignore - 8.1 proof
                $class[] = 'hidden';
            }
            if ( 'cb' === $column_key ) {
                $class[] = 'check-column';
            } elseif ( in_array( $column_key, array('posts', 'comments', 'links') ) ) {
                $class[] = 'num';
            }
            if ( $column_key === $primary ) {
                $class[] = 'column-primary';
            }
            if ( isset( $sortable[$column_key] ) ) {
                list( $orderby, $desc_first ) = (array) $sortable[$column_key];
                //phpcs:ignore - 8.1 proof
                if ( $current_orderby === $orderby ) {
                    $order = ( 'asc' === $current_order ? 'desc' : 'asc' );
                    $class[] = 'sorted';
                    $class[] = $current_order;
                } else {
                    $order = ( $desc_first ? 'desc' : 'asc' );
                    $class[] = 'sortable';
                    $class[] = ( $desc_first ? 'asc' : 'desc' );
                }
                // *********************
                // *** BEGIN CHANGES ***
                // *********************
                // Code removed.
                // *******************
                // *** END CHANGES ***
                // *******************
            }
            $tag = ( 'cb' === $column_key ? 'td' : 'th' );
            $scope = ( 'th' === $tag ? 'scope="col"' : '' );
            $id = ( $with_id ? "id='{$column_key}'" : '' );
            if ( !empty( $class ) ) {
                $class = "class='" . join( ' ', $class ) . "'";
            }
            // *********************
            // *** BEGIN CHANGES ***
            // *********************
            echo '<' . esc_attr( $tag ) . ' ' . wp_kses_data( $scope ) . ' ' . wp_kses_data( $id ) . ' ' . wp_kses_data( $class ) . '>';
            if ( isset( $sortable[$column_key] ) ) {
                ?>
					<a href="javascript:void(0)"
					   onclick="jQuery('#wpda_main_form_orderby').val('<?php 
                echo esc_attr( $orderby );
                ?>'); jQuery('#wpda_main_form_order').val('<?php 
                echo esc_attr( $order );
                ?>'); jQuery('#wpda_main_form').submit();">
						<span><?php 
                echo wp_kses_data( $column_display_name );
                ?></span><span
								class="sorting-indicator"></span>
					</a>
					<?php 
            } else {
                echo wp_kses( $column_display_name, array(
                    'input' => array(
                        'id'   => array(),
                        'type' => array(),
                    ),
                    'label' => array(
                        'class' => array(),
                        'for'   => array(),
                    ),
                ) );
            }
            echo '</' . esc_attr( $tag ) . '>';
            // *******************
            // *** END CHANGES ***
            // *******************
        }
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     * @since   1.0.0
     */
    public function get_bulk_actions() {
        if ( !$this->bulk_actions_enabled ) {
            // Bulk actions disabled.
            return '';
        }
        if ( empty( $this->wpda_list_columns->get_table_primary_key() ) ) {
            // Tables has no primary key: no bulk actions allowed!
            // Primary key is necessary to ensure uniqueness.
            return '';
        }
        $actions = array();
        if ( 'on' === $this->allow_delete ) {
            $actions = array(
                'bulk-delete' => __( 'Delete Permanently', 'wp-data-access' ),
            );
        }
        if ( $this->bulk_export_enabled && (WPDA::is_wpda_table( $this->table_name ) || WPDA::get_option( WPDA::OPTION_BE_EXPORT_ROWS ) === 'on') ) {
            if ( 'diehard' !== $this->page ) {
                // Not allowed on web page.
                $actions['bulk-export'] = __( 'Export to SQL', 'wp-data-access' );
            }
            $actions['bulk-export-xml'] = __( 'Export to XML', 'wp-data-access' );
            $actions['bulk-export-json'] = __( 'Export to JSON', 'wp-data-access' );
            $actions['bulk-export-excel'] = __( 'Export to Excel', 'wp-data-access' );
            $actions['bulk-export-csv'] = __( 'Export to CSV', 'wp-data-access' );
        }
        return $actions;
    }

    /**
     * Generates the table navigation
     *
     * Generates the table navigation above or bellow the table and removes the
     * _wp_http_referrer and _wpnonce because it generates a error about URL too large.
     *
     * @param string $which CSS Class name.
     *
     * @return void
     * @since   1.0.0
     */
    protected function display_tablenav( $which ) {
        if ( !$this->hide_navigation && $this->items ) {
            ?>
				<div class="tablenav <?php 
            echo esc_attr( $which );
            ?>">
					<div class="alignleft actions">
						<?php 
            $this->bulk_actions( $which );
            ?>
					</div>
					<span id="wpda_row_export_anchor"></span>
					<?php 
            $this->add_full_table_downloads();
            $this->extra_tablenav( $which );
            $this->pagination( $which );
            ?>
					<br class="clear"/>
				</div>
				<?php 
        } else {
            ?>
				<br class="clear"/>
				<?php 
        }
    }

    /**
     * Add full export to CSV and JSON buttons
     * Needs to be granted in project page configuration
     */
    protected function add_full_table_downloads() {
    }

    // Override to add arguments to CSV and JSON full table exports.
    protected function add_full_table_downloads_add_args() {
    }

    /**
     * Display the pagination
     *
     * Overriding original method pagination to support post instead of get.
     * Changes are marked!
     *
     * @param string $which CSS Class name.
     *
     * @since   1.0.0
     */
    protected function pagination( $which ) {
        if ( empty( $this->_pagination_args ) ) {
            return;
        }
        $total_items = $this->_pagination_args['total_items'];
        $total_pages = $this->_pagination_args['total_pages'];
        $infinite_scroll = false;
        if ( isset( $this->_pagination_args['infinite_scroll'] ) ) {
            $infinite_scroll = $this->_pagination_args['infinite_scroll'];
        }
        if ( 'top' === $which && $total_pages > 1 ) {
            $this->screen->render_screen_reader_content( 'heading_pagination' );
        }
        // Add estimate character if row_count_estimate is enabled.
        $estimate = ( $this->row_count_estimate['is_estimate'] ? '~' : '' );
        /* translators: %s: number of items (2x) */
        $output = '<span class="displaying-num">' . sprintf( _n( '%s item', '%s items', $total_items ), $estimate . number_format_i18n( $total_items ) ) . '</span>';
        $current = $this->get_pagenum();
        if ( $this->search_value !== $this->search_value_old ) {
            $current = 1;
        }
        // *********************
        // *** BEGIN CHANGES ***
        // *********************
        // Code removed.
        // *******************
        // *** END CHANGES ***
        // *******************
        $page_links = array();
        $total_pages_before = '<span class="paging-input">';
        $total_pages_after = '</span></span>';
        $disable_first = $disable_last = $disable_prev = $disable_next = false;
        if ( 1 === (int) $current ) {
            $disable_first = true;
            $disable_prev = true;
        }
        if ( 2 === (int) $current ) {
            $disable_first = true;
        }
        if ( (int) $current === (int) $total_pages ) {
            $disable_last = true;
            $disable_next = true;
        }
        if ( (int) $current === (int) $total_pages - 1 ) {
            $disable_last = true;
        }
        // *********************
        // *** BEGIN CHANGES ***
        // *********************
        $link_with_post_support = "\n            <a class='%s'\n                href='javascript:void(0)'\n                onclick='jQuery(\"#current-page-selector\").val(\"%s\"); jQuery(\"#wpda_main_form\").submit();'>\n                <span class='screen-reader-text'>%s</span>\n                <span aria-hidden='true'>%s</span>\n            </a>";
        // *******************
        // *** END CHANGES ***
        // *******************
        if ( $disable_first ) {
            $page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&laquo;</span>';
        } else {
            // *********************
            // *** BEGIN CHANGES ***
            // *********************
            $page_links[] = sprintf(
                $link_with_post_support,
                'first-page button',
                '',
                __( 'First page' ),
                '&laquo;'
            );
            // *******************
            // *** END CHANGES ***
            // *******************
        }
        if ( $disable_prev ) {
            $page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&lsaquo;</span>';
        } else {
            // *********************
            // *** BEGIN CHANGES ***
            // *********************
            $page_links[] = sprintf(
                $link_with_post_support,
                'prev-page button',
                max( 1, $current - 1 ),
                __( 'Previous page' ),
                '&lsaquo;'
            );
            // *******************
            // *** END CHANGES ***
            // *******************
        }
        if ( 'bottom' === $which ) {
            $html_current_page = $current;
            $total_pages_before = '<span class="screen-reader-text">' . __( 'Current Page' ) . '</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">';
        } else {
            $html_current_page = sprintf(
                "%s<input class='current-page' id='current-page-selector' type='text' name='paged' value='%s' size='%d' aria-describedby='table-paging' /><span class='tablenav-paging-text'>",
                '<label for="current-page-selector" class="screen-reader-text">' . __( 'Current Page' ) . '</label>',
                $current,
                strlen( (string) $total_pages )
            );
        }
        $html_total_pages = sprintf( "<span class='total-pages'>%s</span>", number_format_i18n( $total_pages ) );
        /* translators: %s: current page/total pages */
        $page_links[] = $total_pages_before . sprintf( _x( '%1$s of %2$s', 'paging' ), $html_current_page, $html_total_pages ) . $total_pages_after;
        if ( $disable_next ) {
            $page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&rsaquo;</span>';
        } else {
            // *********************
            // *** BEGIN CHANGES ***
            // *********************
            $page_links[] = sprintf(
                $link_with_post_support,
                'next-page button',
                min( $total_pages, $current + 1 ),
                __( 'Next page' ),
                '&rsaquo;'
            );
            // *******************
            // *** END CHANGES ***
            // *******************
        }
        if ( $disable_last ) {
            $page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&raquo;</span>';
        } else {
            // *********************
            // *** BEGIN CHANGES ***
            // *********************
            $page_links[] = sprintf(
                $link_with_post_support,
                'last-page button',
                $total_pages,
                __( 'Last page' ),
                '&raquo;'
            );
            // *******************
            // *** END CHANGES ***
            // *******************
        }
        $pagination_links_class = 'pagination-links';
        if ( !empty( $infinite_scroll ) ) {
            $pagination_links_class = ' hide-if-js';
        }
        $output .= "\n<span class='{$pagination_links_class}'>" . join( "\n", $page_links ) . '</span>';
        if ( $total_pages ) {
            $page_class = ( $total_pages < 2 ? ' one-page' : '' );
        } else {
            $page_class = ' no-pages';
        }
        $this->_pagination = "<div class='tablenav-pages{$page_class}'>{$output}</div>";
        echo $this->_pagination;
        // phpcs:ignore WordPress.Security.EscapeOutput
    }

}
