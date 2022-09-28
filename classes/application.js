"use strict";

export class Application {
	/**
	 * Matches the Applications table in the database
	 * @param {int} user_id 
	 * @param {int} post_id 
	 * @param {int} status
	 * 1 = Awaiting response;
	 * 2 = Declined;
	 * 3 = Accepted;
	 */

	constructor(user_id, post_id, status) {
		this.user_id = user_id; // Primary key (Double)
		this.post_id = post_id; // Primary key (Double)
		this.status = status;
	}
}