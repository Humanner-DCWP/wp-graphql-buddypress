<?php
/**
 * MembersConnectionResolver Class
 *
 * @package WPGraphQL\Extensions\BuddyPress\Data\Connection
 * @since 0.0.1-alpha
 */

namespace WPGraphQL\Extensions\BuddyPress\Data\Connection;

use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use WPGraphQL\Types;
use WPGraphQL\Data\Connection\AbstractConnectionResolver;

/**
 * Class MembersConnectionResolver
 */
class MembersConnectionResolver extends AbstractConnectionResolver {

	/**
	 * Get query args.
	 *
	 * @return array
	 */
	public function get_query_args() {
		$query_args = [
			'type'                => 'newest',
			'user_id'             => false,
			'user_ids'            => false,
			'exclude'             => false,
			'xprofile_query'      => false,
			'member_type'         => '',
			'member_type__in'     => '',
			'member_type__not_in' => '',
		];

		/**
		 * Prepare for later use
		 */
		$last = ! empty( $this->args['last'] ) ? $this->args['last'] : null;

		/**
		 * Collect the input_fields.
		 */
		$input_fields = [];
		if ( ! empty( $this->args['where'] ) ) {
			$input_fields = $this->sanitize_input_fields( $this->args['where'] );
		}

		if ( ! empty( $input_fields ) ) {
			$query_args = array_merge( $query_args, $input_fields );
		}

		/**
		 * Set the graphql_cursor_offset
		 */
		$query_args['graphql_cursor_offset']  = $this->get_offset();
		$query_args['graphql_cursor_compare'] = ( ! empty( $last ) ) ? '>' : '<';

		/**
		 * Pass the graphql $this->args.
		 */
		$query_args['graphql_args'] = $this->args;

		/**
		 * Filter the query_args that should be applied to the query. This filter is applied AFTER the input args from
		 * the GraphQL Query have been applied and has the potential to override the GraphQL Query Input Args.
		 *
		 * @param array       $query_args array of query_args being passed to the
		 * @param mixed       $source     Source passed down from the resolve tree
		 * @param array       $args       array of arguments input in the field as part of the GraphQL query
		 * @param AppContext  $context    object passed down zthe resolve tree
		 * @param ResolveInfo $info       info about fields passed down the resolve tree
		 */
		return apply_filters(
			'graphql_members_connection_query_args',
			$query_args,
			$this->source,
			$this->args,
			$this->context,
			$this->info
		);
	}

	/**
	 * Returns array of members.
	 *
	 * @return array
	 */
	public function get_query() {
		return new \BP_User_Query( $this->query_args );
	}

	/**
	 * Returns an array of member ids.
	 *
	 * @return array
	 */
	public function get_items() {
		return wp_list_pluck(
			array_values( $this->query->results ),
			'ID'
		);
	}

	/**
	 * This can be used to determine whether the connection query should even execute.
	 *
	 * @return bool
	 */
	public function should_execute() {
		return true;
	}

	/**
	 * This sets up the "allowed" args, and translates the GraphQL-friendly keys to
	 * BP_User_Query() friendly keys.
	 *
	 * @param array $args The array of query arguments.
	 *
	 * @return array
	 */
	public function sanitize_input_fields( array $args ) {
		$arg_mapping = [
			'type'            => 'type',
			'userId'          => 'user_id',
			'include'         => 'user_ids',
			'exclude'         => 'exclude',
			'xprofile'        => 'xprofile_query',
			'memberType'      => 'member_type',
			'memberTypeIn'    => 'member_type__in',
			'memberTypeNotIn' => 'member_type__not_in',
			'search'          => 'search_terms',
		];

		/**
		 * Map and sanitize the input args to the BP_User_Query compatiable args.
		 */
		$query_args = Types::map_input( $args, $arg_mapping );

		/**
		 * This allows plugins/themes to hook in and alter what $args should be allowed.
		 */
		$query_args = apply_filters(
			'graphql_map_input_fields_to_members_query',
			$query_args,
			$args,
			$this->source,
			$this->args,
			$this->context,
			$this->info
		);

		if ( empty( $query_args ) || ! is_array( $query_args ) ) {
			return [];
		}

		return $query_args;
	}
}