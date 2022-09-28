"use strict";

export class Save {
	/**
	 * Matches the Saves table in the database
	 * @param {int} user_id 
	 * @param {int} post_id 
	 */

	constructor(user_id, post_id) {
		this.user_id = user_id; // Primary key (Double)
		this.post_id = post_id; // Primary key (Double)
	}
}