<?php
/**
 * Factory Class
 *
 * This class serves as a factory for all the resolvers.
 *
 * @package WPGraphQL\Extensions\BuddyPress\Data
 * @since 0.0.1-alpha
 */

namespace WPGraphQL\Extensions\BuddyPress\Data;

use GraphQL\Deferred;
use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use WPGraphQL\Extensions\BuddyPress\Data\Connection\GroupsConnectionResolver;

/**
 * Class Factory
 */
class Factory {

	/**
	 * Returns a Group object.
	 *
	 * @param int|null   $id      Group ID or null.
	 * @param AppContext $context AppContext object.
	 *
	 * @return Deferred|null
	 */
	public static function resolve_group_object( $id, AppContext $context ) {
		if ( empty( $id ) || ! absint( $id ) ) {
			return null;
		}

		$group_id = absint( $id );
		$context->getLoader( 'group_object' )->buffer( [ $group_id ] );

		return new Deferred(
			function () use ( $group_id, $context ) {
				return $context->getLoader( 'group_object' )->load( $group_id );
			}
		);
	}

	/**
	 * Wrapper for the GroupsConnectionResolver class.
	 *
	 * @param mixed       $source  Source.
	 * @param array       $args    Query args to pass to the connection resolver.
	 * @param AppContext  $context The context of the query to pass along.
	 * @param ResolveInfo $info    The ResolveInfo object.
	 *
	 * @return array
	 */
	public static function resolve_groups_connection( $source, array $args, AppContext $context, ResolveInfo $info ) {
		return ( new GroupsConnectionResolver( $source, $args, $context, $info ) )->get_connection();
	}
}
