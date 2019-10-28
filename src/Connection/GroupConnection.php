<?php
/**
 * Registers Groups Connections
 *
 * @package \WPGraphQL\Extensions\BuddyPress\Connection
 * @since 0.0.1-alpha
 */

namespace WPGraphQL\Extensions\BuddyPress\Connection;

use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use WPGraphQL\Extensions\BuddyPress\Data\Factory;

/**
 * Class GroupConnection
 */
class GroupConnection {

	/**
	 * Register connections to Groups
	 */
	public static function register_connections() {

		/**
		 * Register connection from RootQuery to groups
		 */
		register_graphql_connection( self::get_connection_config() );

		/**
		 * Register connection from Group to children groups
		 */
		register_graphql_connection(
			self::get_connection_config(
				[
					'fromType'      => 'Group',
					'fromFieldName' => 'children',
				]
			)
		);
	}

	/**
	 * Given an array of $args, this returns the connection config, merging the provided args
	 * with the defaults.
	 *
	 * @param array $args Array of arguments.
	 *
	 * @return array
	 */
	public static function get_connection_config( $args = [] ) {
		$defaults = [
			'fromType'       => 'RootQuery',
			'toType'         => 'Group',
			'fromFieldName'  => 'groups',
			'connectionArgs' => self::get_connection_args(),
			'resolveNode'    => function ( $id, array $args, AppContext $context ) {
				return Factory::resolve_group_object( $id, $context );
			},
			'resolve'        => function ( $source, array $args, AppContext $context, ResolveInfo $info ) {
				return Factory::resolve_groups_connection( $source, $args, $context, $info );
			},
		];

		return array_merge( $defaults, $args );
	}

	/**
	 * This returns the connection args for the Group connection
	 *
	 * @return array
	 */
	public static function get_connection_args() {
		return [
			'showHidden'  => [
				'type'        => 'Boolean',
				'description' => __( 'Whether results should include hidden Groups.', 'wp-graphql-buddypress' ),
			],
			'enableForum' => [
				'type'        => 'Boolean',
				'description' => __( 'Whether the Group has a forum enabled or not.', 'wp-graphql-buddypress' ),
			],
			'order'       => [
				'type'        => 'OrderEnum',
				'description' => __( 'Order sort attribute ascending or descending.', 'wp-graphql-buddypress' ),
			],
			'parent'      => [
				'type'        => 'Int',
				'description' => __( 'Parent ID of group to retrieve children of.', 'wp-graphql-buddypress' ),
			],
			'search'      => [
				'type'        => 'String',
				'description' => __( 'Search term(s) to retrieve matching groups for.', 'wp-graphql-buddypress' ),
			],
			'status'      => [
				'type'        => 'String',
				'description' => __( 'Group statuses to limit results to.', 'wp-graphql-buddypress' ),
			],
			'groupType'   => [
				'type'        => 'String',
				'description' => __( 'Include groups of a given type.', 'wp-graphql-buddypress' ),
			],
			'userId'      => [
				'type'        => 'Int',
				'description' => __( 'Include groups that this user is a member of.', 'wp-graphql-buddypress' ),
			],
		];
	}
}